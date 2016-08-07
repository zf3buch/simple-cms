<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageBackendTest\Controller;

use PageBackend\Controller\DisplayController;
use Application\Test\HttpControllerTestCaseTrait;
use UserModel\Permissions\Role\AdminRole;
use Zend\Db\Sql\Sql;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class DisplayControllerTest
 *
 * @package PageBackendTest\Controller
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
            'page'  => PROJECT_ROOT
                . "/data/test-data/page.test-data.csv",
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
     * @group        page-backend
     * @dataProvider provideIndexActionCanBeAccessed
     */
    public function testIndexActionCanBeAccessed($url, $locale, $route, $h1
    ) {
        $this->mockLogin(AdminRole::NAME);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName($route);
        $this->assertModuleName('pagebackend');
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
                '/de/page-backend', 'de_DE', 'page-backend',
                'page_backend_h1_display_index'
            ],
            [
                '/en/page-backend', 'en_US', 'page-backend',
                'page_backend_h1_display_index'
            ],
        ];
    }

    /**
     * Test index action output
     *
     * @param $page
     *
     * @group        controller
     * @group        page-backend
     * @dataProvider provideIndexActionPageOutput
     */
    public function testIndexActionPageOutput($page)
    {
        $this->mockLogin(AdminRole::NAME);

        $url = $page == 1
            ? '/de/page-backend'
            : '/de/page-backend/' . $page;

        $this->dispatch($url, 'GET');

        $queryPage = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPagesByPage($page)
        );

        for ($count = 0; $count < $queryPage->getRowCount(); $count++) {
            $row = $queryPage->getRow($count);

            $this->assertQueryContentRegex(
                'table tbody tr td a',
                '#' . preg_quote($row['title']) . '#'
            );
            $this->assertQueryContentRegex(
                'table tbody tr td',
                '#' . preg_quote($row['category_name']) . '#'
            );
        }
    }

    /**
     * @return array
     */
    public function provideIndexActionPageOutput()
    {
        return [
            [1],
            [2],
        ];
    }

    /**
     * Test detail action can be accessed
     *
     * @param $id
     *
     * @group        controller
     * @group        page-backend
     * @dataProvider provideDetailActionCanBeAccessed
     */
    public function testDetailActionCanBeAccessed($id)
    {
        $this->mockLogin(AdminRole::NAME);

        $queryPage = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        );

        $row = $queryPage->getRow(0);

        $url = '/de/page-backend/show/' . $id;

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName(
            'page-backend/show'
        );
        $this->assertModuleName('pagebackend');
        $this->assertControllerName(DisplayController::class);
        $this->assertControllerClass('DisplayController');
        $this->assertActionName('show');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            $this->translator->translate('page_backend_h1_display_show')
        );
    }

    /**
     * @return array
     */
    public function provideDetailActionCanBeAccessed()
    {
        return [
            [1], [3], [15], [17], [18], [19],
        ];
    }

    /**
     * @param int $page
     *
     * @return string
     */
    protected function generateQueryPagesByPage($page = 1)
    {
        $limit  = 15;
        $offset = ($page - 1) * $limit;

        $sql = new Sql($this->adapter);

        $select = $sql->select('page');
        $select->limit($limit);
        $select->offset($offset);
        $select->order(['page.created' => 'DESC']);

        $this->addCategoryJoinToQuery($select);

        return $sql->buildSqlString($select);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    protected function generateQueryPageById($id)
    {
        $sql = new Sql($this->adapter);

        $select = $sql->select('page');
        $select->where->equalTo('page.id', $id);

        $this->addCategoryJoinToQuery($select);

        return $sql->buildSqlString($select);
    }
}
