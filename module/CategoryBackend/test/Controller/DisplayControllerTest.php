<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryBackendTest\Controller;

use CategoryBackend\Controller\DisplayController;
use Application\Test\HttpControllerTestCaseTrait;
use UserModel\Permissions\Role\AdminRole;
use Zend\Db\Sql\Sql;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class DisplayControllerTest
 *
 * @package CategoryBackendTest\Controller
 */
class DisplayControllerTest extends AbstractHttpControllerTestCase
{
    use HttpControllerTestCaseTrait;

    /**
     * @var array
     */
    protected $csvTables
        = [
            'category' => PROJECT_ROOT
                . "/data/test-data/category.test-data.csv",
        ];

    /**
     * Test index action can be accessed
     *
     * @param $url
     * @param $locale
     * @param $route
     * @param $h1
     *
     * @group        controller
     * @group        category-backend
     * @dataProvider provideIndexActionCanBeAccessed
     */
    public function testIndexActionCanBeAccessed($url, $locale, $route, $h1
    ) {
        $this->mockLogin(AdminRole::NAME);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName($route);
        $this->assertModuleName('categorybackend');
        $this->assertControllerName(DisplayController::class);
        $this->assertControllerClass('DisplayController');
        $this->assertActionName('index');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            $this->translator->translate($h1, 'default', $locale)
        );
    }

    /**
     * @return array
     */
    public function provideIndexActionCanBeAccessed()
    {
        return [
            [
                '/de/category-backend', 'de_DE', 'category-backend',
                'category_backend_h1_display_index'
            ],
            [
                '/en/category-backend', 'en_US', 'category-backend',
                'category_backend_h1_display_index'
            ],
        ];
    }

    /**
     * Test index action output
     *
     * @param $page
     *
     * @group        controller
     * @group        category-backend
     */
    public function testIndexActionCategoryOutput()
    {
        $this->mockLogin(AdminRole::NAME);

        $page = 1;
        $url = '/de/category-backend';

        $this->dispatch($url, 'GET');

        $queryCategory = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoriesByPage($page)
        );

        for ($count = 0; $count < $queryCategory->getRowCount(); $count++) {
            $row = $queryCategory->getRow($count);

            $this->assertQueryContentRegex(
                'table tbody tr td a',
                '#' . preg_quote($row['name']) . '#'
            );
            $this->assertQueryContentRegex(
                'table tbody tr td',
                '#' . preg_quote(strip_tags($row['description'])) . '#'
            );
        }
    }

    /**
     * Test detail action can be accessed
     *
     * @param $id
     *
     * @group        controller
     * @group        category-backend
     * @dataProvider provideDetailActionCanBeAccessed
     */
    public function testDetailActionCanBeAccessed($id)
    {
        $this->mockLogin(AdminRole::NAME);

        $queryCategory = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        );

        $row = $queryCategory->getRow(0);

        $url = '/de/category-backend/show/' . $id;

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName(
            'category-backend/show'
        );
        $this->assertModuleName('categorybackend');
        $this->assertControllerName(DisplayController::class);
        $this->assertControllerClass('DisplayController');
        $this->assertActionName('show');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            $this->translator->translate('category_backend_h1_display_show')
        );
    }

    /**
     * @return array
     */
    public function provideDetailActionCanBeAccessed()
    {
        return [
            [1], [3], [5], [7], [8], [9],
        ];
    }

    /**
     * @param int $page
     *
     * @return string
     */
    protected function generateQueryCategoriesByPage($page = 1)
    {
        $limit  = 15;
        $offset = ($page - 1) * $limit;

        $sql = new Sql($this->adapter);

        $select = $sql->select('category');
        $select->limit($limit);
        $select->offset($offset);
        $select->order(['category.name' => 'ASC']);

        return $sql->buildSqlString($select);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    protected function generateQueryCategoryById($id)
    {
        $sql = new Sql($this->adapter);

        $select = $sql->select('category');
        $select->where->equalTo('category.id', $id);

        return $sql->buildSqlString($select);
    }
}
