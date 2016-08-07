<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageFrontendTest\Controller;

use Application\Test\HttpControllerTestCaseTrait;
use PageFrontend\Controller\DisplayController;
use Zend\Db\Sql\Sql;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class DisplayControllerTest
 *
 * @package PageFrontendTest\Controller
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
            'page'     => PROJECT_ROOT
                . "/data/test-data/page.test-data.csv",
        ];

    /**
     * Test category action can be accessed
     *
     * @param $url
     * @param $locale
     *
     * @group        controller
     * @group        page-frontend
     * @dataProvider provideCategoryActionCanBeAccessed
     */
    public function testCategoryActionCanBeAccessed(
        $url, $locale, $category
    ) {
        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName('category');
        $this->assertModuleName('pagefrontend');
        $this->assertControllerName(DisplayController::class);
        $this->assertControllerClass('DisplayController');
        $this->assertActionName('category');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            sprintf(
                $this->translator->translate(
                    'page_frontend_h1_category', 'default', $locale
                ),
                $category
            )
        );
    }

    /**
     * @return array
     */
    public function provideCategoryActionCanBeAccessed()
    {
        return [
            ['/de/category/sport', 'de_DE', 'Sport'],
            ['/de/category/katzen', 'de_DE', 'Katzen'],
            ['/en/category/business', 'en_US', 'Business'],
            ['/de/category/nachtleben', 'de_DE', 'Nachtleben'],
            ['/en/category/autos', 'en_US', 'Autos'],
        ];
    }

    /**
     * Test category action output
     *
     * @param $url
     *
     * @group        controller
     * @group        page-frontend
     * @dataProvider provideCategoryActionPageOutput
     */
    public function testCategoryActionPageOutput($url)
    {
        $this->dispatch('/de/category/' . $url, 'GET');

        $queryPage = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPagesByPage($url)
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
     * @return array
     */
    public function provideCategoryActionPageOutput()
    {
        return [
            ['sport'],
            ['katzen'],
            ['business'],
            ['nachtleben'],
            ['autos'],
        ];
    }

    /**
     * Test page action can be accessed
     *
     * @param $url
     *
     * @group        controller
     * @group        page-frontend
     * @dataProvider providePageActionCanBeAccessed
     */
    public function testPageActionCanBeAccessed($url)
    {
        $queryPage = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageByUrl($url)
        );

        $row = $queryPage->getRow(0);

        $this->dispatch('/de/page/' . $url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName(
            'page'
        );
        $this->assertModuleName('pagefrontend');
        $this->assertControllerName(DisplayController::class);
        $this->assertControllerClass('DisplayController');
        $this->assertActionName('page');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            utf8_encode($row['title'])
        );
    }

    /**
     * @return array
     */
    public function providePageActionCanBeAccessed()
    {
        return [
            ['die-schrottkarren-des-jahres'],
            ['kunden-abzocken-fuer-anfaenger'],
            ['tipps-zum-kostenlosen-besaufen-auf-sylt'],
            ['sport-fuer-sofakartoffeln'],
            ['reifenwechseln-fuer-kettenraucher'],
            ['lueften-fuer-frischluft-phobiker'],
            ['der-hund-der-durch-den-brennenden-reifen-sprang'],
        ];
    }

    /**
     * Test page action is redirected
     *
     * @param $url
     *
     * @group        controller
     * @group        page-frontend
     * @dataProvider providePageActionIsRedirected
     */
    public function testPageActionIsRedirected($url)
    {
        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->assertRedirectTo('/');
    }

    /**
     * @return array
     */
    public function providePageActionIsRedirected()
    {
        return [
            ['/de/page/abhaengen-in-new-york'],
            ['/de/page/als-meine-katze-ihren-haustuerschluessel-vergas'],
            ['/de/page/'],
        ];
    }

    /**
     * @param string $url
     *
     * @return string
     */
    protected function generateQueryPagesByPage($url)
    {
        $sql = new Sql($this->adapter);

        $select = $sql->select('page');
        $select->order(['page.created' => 'DESC']);
        $select->where->equalTo('category.url', $url);

        $this->addCategoryJoinToQuery($select);

        return $sql->buildSqlString($select);
    }

    /**
     * @param int $url
     *
     * @return string
     */
    protected function generateQueryPageByUrl($url)
    {
        $sql = new Sql($this->adapter);

        $select = $sql->select('page');
        $select->where->equalTo('page.status', 'approved');
        $select->where->equalTo('page.url', $url);

        $this->addCategoryJoinToQuery($select);

        return $sql->buildSqlString($select);
    }
}
