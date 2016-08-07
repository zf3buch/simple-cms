<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace ApplicationTest\Controller;

use Application\Controller\IndexController;
use Application\Test\HttpControllerTestCaseTrait;
use Zend\Db\Sql\Sql;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class IndexControllerTest
 *
 * @package ApplicationTest\Controller
 */
class IndexControllerTest extends AbstractHttpControllerTestCase
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
                . "/data/test-data/page.homepage.test-data.csv",
        ];

    /**
     * Test index action without lang
     *
     * @group controller
     * @group application
     */
    public function testIndexActionWithoutLangCannotBeAccessed()
    {
        $this->dispatch('/', 'GET');
        $this->assertResponseStatusCode(301);
        $this->assertRedirect();
        $this->assertRedirectTo('/de');
    }

    /**
     * Test index action with de lang
     *
     * @param $url
     * @param $locale
     *
     * @group        controller
     * @group        application
     * @dataProvider provideIndexActionCanBeAccessed
     */
    public function testIndexActionCanBeAccessed($url, $locale)
    {
        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName('home');
        $this->assertModuleName('application');
        $this->assertControllerName(IndexController::class);
        $this->assertControllerClass('IndexController');
        $this->assertActionName('index');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            $this->translator->translate(
                'application_h1_index_index', 'default', $locale
            )
        );
    }

    /**
     * @return array
     */
    public function provideIndexActionCanBeAccessed()
    {
        return [
            ['/de', 'de_DE'],
            ['/en', 'en_US'],
        ];
    }

    /**
     * Test index action output
     *
     * @group controller
     * @group application
     */
    public function testIndexActionRandomPages()
    {
        $this->dispatch('/de', 'GET');

        $queryPage = $this->getConnection()->createQueryTable(
            'fetchJob',
            $this->generateQueryPageRandom()
        );

        for ($count = 0; $count < $queryPage->getRowCount(); $count++) {
            $row = $queryPage->getRow($count);

            $this->assertQueryContentRegex(
                '.panel-primary .panel-heading strong a',
                '#' . preg_quote($row['title']) . '#'
            );
        }
    }

    /**
     * @return string
     */
    protected function generateQueryPageRandom()
    {
        $sql = new Sql($this->adapter);

        $select = $sql->select('page');
        $select->limit(4);

        $this->addCategoryJoinToQuery($select);

        return $sql->buildSqlString($select);
    }
}
