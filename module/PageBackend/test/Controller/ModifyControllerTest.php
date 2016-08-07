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

use Application\Test\HttpControllerTestCaseTrait;
use PageBackend\Controller\ModifyController;
use UserModel\Permissions\Role\AdminRole;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\Parameters;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class ModifyControllerTest
 *
 * @package PageBackendTest\Controller
 */
class ModifyControllerTest extends AbstractHttpControllerTestCase
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
     * Test add action can be accessed
     *
     * @group        controller
     * @group        page-backend
     */
    public function testAddActionCanBeAccessed()
    {
        $this->mockLogin(AdminRole::NAME);

        $url = '/de/page-backend/add';

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName('page-backend/modify');
        $this->assertModuleName('pagebackend');
        $this->assertControllerName(ModifyController::class);
        $this->assertControllerClass('ModifyController');
        $this->assertActionName('add');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            $this->translator->translate(
                'page_backend_h1_display_add', 'default', 'de_DE'
            )
        );

        $this->assertFormElementsExist(
            'page_form',
            [
                'csrf', 'status', 'category', 'author', 'title',
                'text', 'save_page'
            ]
        );
    }

    /**
     * Test add action invalid data
     *
     * @group        controller
     * @group        page-backend
     */
    public function testAddActionInvalidData()
    {
        $this->mockLogin(AdminRole::NAME);

        $url = '/de/page-backend/add';

        $postArray = [
            'id'        => 20,
            'csrf'      => '123456',
            'status'    => 'approved',
            'category'  => '99',
            'author'    => '',
            'title'     => 'Test page',
            'text'      => '<p>Description for test page</p>',
            'save_page' => 'save_page',
        ];

        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters($postArray));

        $this->dispatch($url, 'POST');
        $this->assertResponseStatusCode(200);
        $this->assertNotRedirect();

        $this->assertQueryContentRegex(
            '.alert-danger p',
            '#' . preg_quote(
                $this->translator->translate(
                    'page_backend_message_form_timeout',
                    'default',
                    'de_DE'
                )
            ) . '#'
        );

        $this->assertQueryContentRegex(
            'form .form-group ul li',
            '#' . preg_quote(
                $this->translator->translate(
                    'page_model_message_category_invalid',
                    'default',
                    'de_DE'
                )
            ) . '#'
        );

        $this->assertQueryContentRegex(
            'form .form-group ul li',
            '#' . preg_quote(
                $this->translator->translate(
                    'page_model_message_author_missing',
                    'default',
                    'de_DE'
                )
            ) . '#'
        );

        $this->assertQueryContentRegex(
            'form .form-group ul li',
            '#' . preg_quote(
                str_replace(
                    '%min%',
                    200,
                    $this->translator->translate(
                        'page_model_message_text_invalid',
                        'default',
                        'de_DE'
                    )
                )
            ) . '#'
        );

        $queryPage = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($postArray['id'])
        );

        $this->assertEquals(0, $queryPage->getRowCount());

    }

    /**
     * Test add action successful handling
     *
     * @group        controller
     * @group        page-backend
     */
    public function testAddActionSuccessfulHandling()
    {
        $this->mockLogin(AdminRole::NAME);

        $url = '/de/page-backend/add';

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $postArray = [
            'id'        => 20,
            'csrf'      => $this->getCsrfValue('page_form'),
            'status'    => 'approved',
            'category'  => '3',
            'author'    => 'Jim Beam',
            'title'     => 'Test page',
            'text'      => str_repeat(
                '<p>Description for test page</p>', 10
            ),
            'save_page' => 'save_page',
        ];

        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters($postArray));

        $this->dispatch($url, 'POST');
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->assertRedirectTo('/de/page-backend/edit/20');

        $queryPage = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($postArray['id'])
        );

        $row = $queryPage->getRow(0);

        $this->assertEquals($postArray['id'], $row['id']);
        $this->assertEquals($postArray['status'], $row['status']);
        $this->assertEquals($postArray['category'], $row['category']);
        $this->assertEquals($postArray['author'], $row['author']);
        $this->assertEquals($postArray['title'], $row['title']);
        $this->assertEquals($postArray['text'], $row['text']);
    }

    /**
     * Test edit action can be accessed
     *
     * @group        controller
     * @group        page-backend
     */
    public function testEditActionCanBeAccessed()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 1;
        $url = '/de/page-backend/edit/' . $id;

        $oldData = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        )->getRow(0);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName('page-backend/modify');
        $this->assertModuleName('pagebackend');
        $this->assertControllerName(ModifyController::class);
        $this->assertControllerClass('ModifyController');
        $this->assertActionName('edit');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            $this->translator->translate(
                'page_backend_h1_display_edit', 'default', 'de_DE'
            )
        );

        $this->assertFormElementsExist(
            'page_form',
            [
                'csrf', 'author', 'title', 'text', 'save_page'
            ]
        );

        $this->assertFormElementValues(
            'page_form',
            [
                'author' => $oldData['author'],
                'title'  => $oldData['title'],
                'text'   => $oldData['text'],
            ]
        );
    }

    /**
     * Test edit action invalid data
     *
     * @group        controller
     * @group        page-backend
     */
    public function testEditActionInvalidData()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 1;
        $url = '/de/page-backend/edit/' . $id;

        $oldData = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        )->getRow(0);

        $postArray = [
            'csrf'      => '123456',
            'author'    => '',
            'title'     => 'Test page',
            'text'      => '<p>Description for test page</p>',
            'save_page' => 'save_page',
        ];

        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters($postArray));

        $this->dispatch($url, 'POST');
        $this->assertResponseStatusCode(200);
        $this->assertNotRedirect();

        $this->assertQueryContentRegex(
            '.alert-danger p',
            '#' . preg_quote(
                $this->translator->translate(
                    'page_backend_message_form_timeout',
                    'default',
                    'de_DE'
                )
            ) . '#'
        );

        $this->assertQueryContentRegex(
            'form .form-group ul li',
            '#' . preg_quote(
                $this->translator->translate(
                    'page_model_message_author_missing',
                    'default',
                    'de_DE'
                )
            ) . '#'
        );

        $this->assertQueryContentRegex(
            'form .form-group ul li',
            '#' . preg_quote(
                str_replace(
                    '%min%',
                    200,
                    $this->translator->translate(
                        'page_model_message_text_invalid',
                        'default',
                        'de_DE'
                    )
                )
            ) . '#'
        );

        $queryPage = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        );

        $row = $queryPage->getRow(0);

        $expectedRow = [
            'id'       => $id,
            'status'   => $oldData['status'],
            'category' => $oldData['category'],
            'title'    => $oldData['title'],
            'text'     => $oldData['text'],
            'author'   => $oldData['author'],
        ];

        $this->assertEquals($expectedRow['id'], $row['id']);
        $this->assertEquals($expectedRow['status'], $row['status']);
        $this->assertEquals($expectedRow['category'], $row['category']);
        $this->assertEquals($expectedRow['author'], $row['author']);
        $this->assertEquals($expectedRow['title'], $row['title']);
    }

    /**
     * Test edit action successful handling
     *
     * @group        controller
     * @group        page-backend
     */
    public function testEditActionSuccessfulHandling()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 1;
        $url = '/de/page-backend/edit/' . $id;

        $oldData = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        )->getRow(0);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $postArray = [
            'csrf'      => $this->getCsrfValue('page_form'),
            'author'    => 'Jim Beam',
            'title'     => 'Test page',
            'text'      => str_repeat(
                '<p>Description for test page</p>', 10
            ),
            'save_page' => 'save_page',
        ];

        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters($postArray));

        $this->dispatch($url, 'POST');
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->assertRedirectTo($url);

        $queryPage = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        );

        $row = $queryPage->getRow(0);

        $expectedRow = [
            'id'       => $id,
            'status'   => $oldData['status'],
            'category' => $oldData['category'],
            'author'   => $postArray['author'],
            'title'    => $postArray['title'],
            'text'     => $postArray['text'],
        ];

        $this->assertEquals($expectedRow['id'], $row['id']);
        $this->assertEquals($expectedRow['status'], $row['status']);
        $this->assertEquals($expectedRow['category'], $row['category']);
        $this->assertEquals($expectedRow['author'], $row['author']);
        $this->assertEquals($expectedRow['title'], $row['title']);
        $this->assertEquals($expectedRow['text'], $row['text']);
    }

    /**
     * Test delete action can be accessed
     *
     * @group        controller
     * @group        page-backend
     */
    public function testDeleteActionCanBeAccessed()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 1;
        $url = '/de/page-backend/delete/' . $id;

        $oldData = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        )->getRow(0);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName('page-backend/modify');
        $this->assertModuleName('pagebackend');
        $this->assertControllerName(ModifyController::class);
        $this->assertControllerClass('ModifyController');
        $this->assertActionName('delete');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            utf8_encode(
                $this->translator->translate(
                    'page_backend_h1_display_delete', 'default', 'de_DE'
                )
            )
        );

        $this->assertQueryContentRegex(
            'form .form-group .form-control-static',
            '#' . preg_quote($oldData['title']) . '#'
        );

        $queryPage = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        );

        $this->assertEquals(1, $queryPage->getRowCount());
    }

    /**
     * Test delete action successful handling
     *
     * @group        controller
     * @group        page-backend
     */
    public function testDeleteActionSuccessfulHandling()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 1;
        $url = '/de/page-backend/delete/' . $id . '?delete=yes';

        $queryPage = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        );

        $this->assertEquals(1, $queryPage->getRowCount());

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->assertRedirectTo('/de/page-backend');

        $queryPage = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        );

        $this->assertEquals(0, $queryPage->getRowCount());
    }

    /**
     * Test approve action can be accessed
     *
     * @group        controller
     * @group        page-backend
     */
    public function testApproveActionCanBeAccessed()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 19;
        $url = '/de/page-backend/approve/' . $id;

        $oldData = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        )->getRow(0);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName('page-backend/modify');
        $this->assertModuleName('pagebackend');
        $this->assertControllerName(ModifyController::class);
        $this->assertControllerClass('ModifyController');
        $this->assertActionName('approve');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            utf8_encode(
                $this->translator->translate(
                    'page_backend_h1_display_approve', 'default', 'de_DE'
                )
            )
        );

        $this->assertQueryContentRegex(
            'form .form-group .form-control-static',
            '#' . preg_quote($oldData['title']) . '#'
        );

        $queryPage = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        );

        $this->assertEquals(1, $queryPage->getRowCount());
    }

    /**
     * Test approve action successful handling
     *
     * @group        controller
     * @group        page-backend
     */
    public function testApproveActionSuccessfulHandling()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 19;
        $url = '/de/page-backend/approve/' . $id . '?approve=yes';

        $oldData = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        )->getRow(0);

        $this->assertEquals('new', $oldData['status']);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->assertRedirectTo('/de/page-backend/show/' . $id);

        $queryPage = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        );

        $row = $queryPage->getRow(0);

        $this->assertEquals('approved', $row['status']);
    }

    /**
     * Test block action can be accessed
     *
     * @group        controller
     * @group        page-backend
     */
    public function testBlockActionCanBeAccessed()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 19;
        $url = '/de/page-backend/block/' . $id;

        $oldData = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        )->getRow(0);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName('page-backend/modify');
        $this->assertModuleName('pagebackend');
        $this->assertControllerName(ModifyController::class);
        $this->assertControllerClass('ModifyController');
        $this->assertActionName('block');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            utf8_encode(
                $this->translator->translate(
                    'page_backend_h1_display_block', 'default', 'de_DE'
                )
            )
        );

        $this->assertQueryContentRegex(
            'form .form-group .form-control-static',
            '#' . preg_quote($oldData['title']) . '#'
        );

        $queryPage = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        );

        $this->assertEquals(1, $queryPage->getRowCount());
    }

    /**
     * Test block action successful handling
     *
     * @group        controller
     * @group        page-backend
     */
    public function testBlockActionSuccessfulHandling()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 19;
        $url = '/de/page-backend/block/' . $id . '?block=yes';

        $oldData = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        )->getRow(0);

        $this->assertEquals('new', $oldData['status']);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->assertRedirectTo('/de/page-backend/show/' . $id);

        $queryPage = $this->getConnection()->createQueryTable(
            'fetchPagesByPage',
            $this->generateQueryPageById($id)
        );

        $row = $queryPage->getRow(0);

        $this->assertEquals('blocked', $row['status']);
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
