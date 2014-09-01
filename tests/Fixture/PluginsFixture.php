<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @since	 1.0.0
 * @author	 Christopher Castro <chris@quickapps.es>
 * @link	 http://www.quickappscms.org
 * @license	 http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace QuickApps\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PluginsFixture class.
 *
 */
class PluginsFixture extends TestFixture {

	public $fields = [];
	public $records = [];

	public function init() {
		include_once QA_CORE .'/config/Schema/plugins.php';
		$fixture = new \plugins();
		$this->fields = $fixture->fields;
		$this->records = $fixture->records;
		parent::init();
	}

}