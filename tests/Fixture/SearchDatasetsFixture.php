<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @since    2.0.0
 * @author   Christopher Castro <chris@quickapps.es>
 * @link     http://www.quickappscms.org
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace CMS\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class SearchDatasetsFixture extends TestFixture
{

    /**
     * Table name.
     *
     * @var string
     */
    public $table = 'search_datasets';
/**
 * Table columns.
 *
 * @var array
 */
    public $fields = [
    '_constraints' =>
    [
    'primary' =>
    [
      'type' => 'primary',
      'columns' =>
      [
        0 => 'id',
      ],
      'length' =>
      [
      ],
    ],
    'search_datasets_entity_id' =>
    [
      'type' => 'unique',
      'columns' =>
      [
        0 => 'entity_id',
        1 => 'table_alias',
      ],
      'length' =>
      [
      ],
    ],
    ],
    '_options' =>
    [
    'engine' => 'InnoDB',
    'collation' => 'utf8_unicode_ci',
    ],
    'id' =>
    [
    'type' => 'integer',
    'unsigned' => false,
    'null' => false,
    'default' => null,
    'comment' => '',
    'autoIncrement' => true,
    'precision' => null,
    ],
    'entity_id' =>
    [
    'type' => 'string',
    'length' => 50,
    'null' => false,
    'default' => null,
    'collate' => 'utf8_unicode_ci',
    'comment' => '',
    'precision' => null,
    'fixed' => null,
    ],
    'table_alias' =>
    [
    'type' => 'string',
    'length' => 50,
    'null' => false,
    'default' => null,
    'collate' => 'utf8_unicode_ci',
    'comment' => '',
    'precision' => null,
    'fixed' => null,
    ],
    'words' =>
    [
    'type' => 'text',
    'length' => 4294967295,
    'null' => true,
    'default' => null,
    'collate' => 'utf8_unicode_ci',
    'comment' => '',
    'precision' => null,
    ],
    ];
/**
 * Table records.
 *
 * @var array
 */
    public $records = [
    0 =>
    [
    'entity_id' => '1',
    'table_alias' => 'contents',
    'words' => ' 1 1 article hello-world ¡hello world! hello world demo article 1 1 1 1 article article use articles for time-sensitive content like news, press releases or blog posts. title 1 1 1 1 1 1 welcome to quickappscms. this is an example content. lorem ipsum dolor sit amet, consectetuer adipiscing elit. aenean commodo ligula eget dolor. aenean massa. cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.nulla consequat massa quis enim. donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. in enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. nullam dictum felis eu pede mollis pretium. integer tincidunt. cras dapibus. vivamus elementum semper nisi. aenean vulputate eleifend tellus. aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. phasellus viverra nulla ut metus varius laoreet. quisque rutrum. aenean imperdiet. etiam ultricies nisi vel augue. curabitur ullamcorper ultricies nisi. nam eget dui. etiam rhoncus.maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. maecenas nec odio et ante tincidunt tempus. donec vitae sapien ut libero venenatis faucibus. nullam quis ante. etiam sit amet orci eget eros faucibus tincidunt. duis leo. sed fringilla mauris sit amet nibh. donec sodales sagittis magna. sed consequat, leo eget bibendum sodales, augue velit cursus nunc 1 5 ',
    ],
    1 =>
    [
    'entity_id' => '2',
    'table_alias' => 'contents',
    'words' => ' about about quickappscms demo page p duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi nbsp span style line height nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum span p p typi non habent claritatem insitam est usus legentis in iis qui facit eorum claritatem investigationes demonstraverunt lectores legere me lius quod ii legunt saepius claritas est etiam processus dynamicus qui sequitur mutationem consuetudium lectorum p p mirum est notare quam littera gothica quam nunc putamus parum claram anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima eodem modo typi qui nunc nobis videntur parum clari fiant sollemnes in futurum p ',
    ],
    2 =>
    [
    'entity_id' => '1',
    'table_alias' => 'users',
    'words' => ' 1 quickappscms admin $2y$10$evi2dymtdegaqd0s9tbjl.wgbpklsjljeh70gxwkrhi6g5dpkr/be chris@quickapps.es http://www.quickappscms.org/ en_us ',
    ],
    ];
}
