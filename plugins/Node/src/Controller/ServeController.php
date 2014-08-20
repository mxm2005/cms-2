<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @since	 2.0.0
 * @author	 Christopher Castro <chris@quickapps.es>
 * @link	 http://www.quickappscms.org
 * @license	 http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Node\Controller;

use Cake\Core\Configure;
use Cake\Error\NotFoundException;
use Cake\Error\ForbiddenException;
use Cake\I18n\I18n;
use Cake\Routing\Router;

/**
 * Node serve controller.
 *
 * For handling all public node-rendering requests.
 */
class ServeController extends AppController {

/**
 * Components used by this controller.
 *
 * @var array
 */
	public $components = [
		'Comment.Comment',
		'Paginator',
		'RequestHandler',
	];

/**
 * An array containing the names of helpers controllers uses.
 *
 * @var array
 */
	public $helpers = [
		'Time',
		'Paginator' => [
			'className' => 'QuickApps\View\Helper\PaginatorHelper',
			'templates' => 'System.paginator-templates.php',
		],
	];

/**
 * Paginator settings.
 *
 * Used by `search()` and `rss()`.
 *
 * @var array
 */
	public $paginate = [
		'limit' => 10,
	];

/**
 * Redirects to ServeController::home()
 *
 * @return void
 */
	public function index() {
		$this->redirect(['plugin' => 'node', 'controller' => 'serve', 'action' => 'home']);
	}

/**
 * Site's home page.
 *
 * Gets a list of all promoted nodes, so themes may render them in their front-page
 * layout. The view-variable `nodes` holds all promoted contents, themes might render
 * this nodes using this variable.
 *
 * @return void
 */
	public function home() {
		$this->loadModel('Node.Nodes');
		$nodes = $this->Nodes->find()
			->where([
				'Nodes.promote' => 1,
				'Nodes.status >' => 0,
				'Nodes.language IN' => ['', I18n::defaultLocale(), null],
			])
			->order(['Nodes.sticky' => 'DESC', 'Nodes.created' => 'DESC'])
			->all();

		$this->set('nodes', $nodes);
	}

/**
 * Node's detail page.
 *
 * @param string $node_type_slug
 * @param string $node_slug
 * @return void
 * @throws \Cake\Error\NotFoundException When content is not found
 * @throws \Cake\Error\ForbiddenException When user can't access this content due to role restrictions
 */
	public function details($node_type_slug, $node_slug) {
		$this->loadModel('Node.Nodes');

		if ($this->request->is('userAdmin')) {
			$conditions = [
				'Nodes.slug' => $node_slug,
				'Nodes.node_type_slug' => $node_type_slug,
			];
		} else {
			$conditions = [
				'Nodes.slug' => $node_slug,
				'Nodes.node_type_slug' => $node_type_slug,
				'Nodes.status >' => 0,
			];
		}

		$node = $this->Nodes->find()
			->where($conditions)
			->contain(['NodeTypes', 'Roles'])
			->first();

		if (!$node) {
			throw new NotFoundException(__d('node', 'The requested page was not found.'));
		} else {
			if (!empty($node->roles)) {
				$nodeRolesID = [];
				foreach ($node->roles as $role) {
					$nodeRolesID[] = $role->id;
				}

				$allowed = false;
				foreach (user()->role_ids as $userRoleID) {
					if (in_array($userRoleID, $nodeRolesID)) {
						$allowed = true;
						break;
					}
				}

				if (!$allowed) {
					throw new ForbiddenException(__d('node', 'You have not sufficient permissions to see this page.'));
				}
			}

			if (!empty($node->language) && $node->language != I18n::defaultLocale()) {
				$haveTranslation = $this->Nodes
					->find()
					->select(['id', 'slug', 'language'])
					->where([
						'translation_for' => $node->id,
						'node_type_slug' => $node_type_slug,
						'language' => I18n::defaultLocale(),
						'status' => 1,
					])
					->first();

				if ($haveTranslation) {
					if (option('url_locale_prefix')) {
						$url = "/{$haveTranslation->language}/{$node_type_slug}/{$haveTranslation->slug}.html";
					} else {
						$url = "/{$node_type_slug}/{$haveTranslation->slug}.html";
					}
					$this->redirect($url);
					return $this->response;
				}

				$isTranslationOf = $this->Nodes
					->find()
					->select(['id', 'slug', 'language'])
					->where([
						'slug' => $node_slug,
						'status' => 1,
						'translation_for NOT IN' => ['', null]
					])
					->first();

				if ($isTranslationOf) {
					if (option('url_locale_prefix')) {
						$url = "/{$isTranslationOf->language}/{$node_type_slug}/{$isTranslationOf->slug}.html";
					} else {
						$url = "/{$node_type_slug}/{$isTranslationOf->slug}.html";
					}
					$this->redirect($url);
					return $this->response;
				}

				throw new NotFoundException(__d('node', 'The requested page was not found.'));
			}
		}

		// Post new comment logic
		if ($node->comment_status > 0) {
			$node->set('comments', $this->Nodes->find('comments', ['for' => $node->id]));
			$this->Comment->config('settings.visibility', $node->comment_status);
			$this->Comment->post($node);
		}

		$this->set('node', $node);
		$this->switchViewMode('full');
	}

/**
 * Node search engine page.
 *
 * @param string $criteria A search criteria.
 * e.g.: `"this phrase" -"but not this" OR -hello`
 * @return void
 */
	public function search($criteria) {
		$this->loadModel('Node.Nodes');

		try {
			$nodes = $this->Nodes->search($criteria);

			if ($nodes->clause('limit')) {
				$this->paginate['limit'] = $nodes->clause('limit');
			}

			$nodes = $this->paginate($nodes);
		} catch (\Exception $e) {
			$nodes = [];
		}

		$this->set(compact('nodes', 'criteria'));
		$this->switchViewMode('search-result');
	}

/**
 * RSS feeder.
 *
 * Similar to `ServeController::search()` but it uses
 * `rss` layout instead of default layout.
 *
 * @param string $criteria A search criteria.
 * e.g.: `"this phrase" -"but not this" OR -hello`
 * @return void
 */
	public function rss($criteria) {
		$this->loadModel('Node.Nodes');

		try {
			$nodes = $this->Nodes
				->search($criteria)
				->limit(10);
		} catch (\Exception $e) {
			$nodes = [];
		}

		$this->set(compact('nodes', 'criteria'));
		$this->switchViewMode('rss');
		$this->RequestHandler->renderAs($this, 'rss');
	}

}