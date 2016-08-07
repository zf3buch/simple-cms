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

use Application\Test\HttpControllerTestCaseTrait;
use CategoryBackend\Controller\ModifyController;
use UserModel\Permissions\Role\AdminRole;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\Parameters;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class ModifyControllerTest
 *
 * @package CategoryBackendTest\Controller
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
        ];

    /**
     * Test add action can be accessed
     *
     * @group        controller
     * @group        category-backend
     */
    public function testAddActionCanBeAccessed()
    {
        $this->mockLogin(AdminRole::NAME);

        $url = '/de/category-backend/add';

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName('category-backend/modify');
        $this->assertModuleName('categorybackend');
        $this->assertControllerName(ModifyController::class);
        $this->assertControllerClass('ModifyController');
        $this->assertActionName('add');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            $this->translator->translate(
                'category_backend_h1_display_add', 'default', 'de_DE'
            )
        );

        $this->assertFormElementsExist(
            'category_form',
            [
                'csrf', 'status', 'name', 'description', 'save_category'
            ]
        );
    }

    /**
     * Test add action invalid data
     *
     * @group        controller
     * @group        category-backend
     */
    public function testAddActionInvalidData()
    {
        $this->mockLogin(AdminRole::NAME);

        $url = '/de/category-backend/add';

        $postArray = [
            'id'            => 13,
            'csrf'          => '123456',
            'status'        => 'approved',
            'name'          => '',
            'description'   => 'description',
            'save_category' => 'save_category',
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
                    'category_backend_message_form_timeout',
                    'default',
                    'de_DE'
                )
            ) . '#'
        );

        $this->assertQueryContentRegex(
            'form .form-group ul li',
            '#' . preg_quote(
                $this->translator->translate(
                    'category_model_message_name_missing',
                    'default',
                    'de_DE'
                )
            ) . '#'
        );

        $this->assertQueryContentRegex(
            'form .form-group ul li',
            '#' . preg_quote(
                str_replace(
                    ['%min%'],
                    [30],
                    $this->translator->translate(
                        'category_model_message_description_invalid',
                        'default',
                        'de_DE'
                    )
                )
            ) . '#'
        );

        $queryCategory = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($postArray['id'])
        );

        $this->assertEquals(0, $queryCategory->getRowCount());

    }

    /**
     * Test add action successful handling
     *
     * @group        controller
     * @group        category-backend
     */
    public function testAddActionSuccessfulHandling()
    {
        $this->mockLogin(AdminRole::NAME);

        $url = '/de/category-backend/add';

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $postArray = [
            'id'            => 13,
            'csrf'          => $this->getCsrfValue('category_form'),
            'status'        => 'approved',
            'name'          => 'Neue Firma',
            'description'   => str_repeat('description', 5),
            'save_category' => 'save_category',
        ];

        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters($postArray));

        $this->dispatch($url, 'POST');
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->assertRedirectTo('/de/category-backend/edit/13');

        $queryCategory = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($postArray['id'])
        );

        $row = $queryCategory->getRow(0);

        $this->assertEquals($postArray['id'], $row['id']);
        $this->assertEquals($postArray['status'], $row['status']);
        $this->assertEquals($postArray['name'], $row['name']);
        $this->assertEquals(
            $postArray['description'], $row['description']
        );
    }

    /**
     * Test edit action can be accessed
     *
     * @group        controller
     * @group        category-backend
     */
    public function testEditActionCanBeAccessed()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 1;
        $url = '/de/category-backend/edit/' . $id;

        $oldData = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        )->getRow(0);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName('category-backend/modify');
        $this->assertModuleName('categorybackend');
        $this->assertControllerName(ModifyController::class);
        $this->assertControllerClass('ModifyController');
        $this->assertActionName('edit');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            $this->translator->translate(
                'category_backend_h1_display_edit', 'default', 'de_DE'
            )
        );

        $this->assertFormElementsExist(
            'category_form',
            [
                'csrf', 'name', 'description', 'save_category'
            ]
        );

        $this->assertFormElementValues(
            'category_form',
            [
                'name'        => $oldData['name'],
                'description' => $oldData['description'],
            ]
        );
    }

    /**
     * Test edit action invalid data
     *
     * @group        controller
     * @group        category-backend
     */
    public function testEditActionInvalidData()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 1;
        $url = '/de/category-backend/edit/' . $id;

        $oldData = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        )->getRow(0);

        $postArray = [
            'csrf'          => '123456',
            'name'          => '',
            'description'   => 'description',
            'save_category' => 'save_category',
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
                    'category_backend_message_form_timeout',
                    'default',
                    'de_DE'
                )
            ) . '#'
        );

        $this->assertQueryContentRegex(
            'form .form-group ul li',
            '#' . preg_quote(
                $this->translator->translate(
                    'category_model_message_name_missing',
                    'default',
                    'de_DE'
                )
            ) . '#'
        );

        $this->assertQueryContentRegex(
            'form .form-group ul li',
            '#' . preg_quote(
                str_replace(
                    ['%min%'],
                    [30],
                    $this->translator->translate(
                        'category_model_message_description_invalid',
                        'default',
                        'de_DE'
                    )
                )
            ) . '#'
        );

        $queryCategory = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        );

        $row = $queryCategory->getRow(0);

        $expectedRow = [
            'id'          => $id,
            'status'      => $oldData['status'],
            'name'        => $oldData['name'],
            'description' => $oldData['description'],
        ];

        $this->assertEquals($expectedRow['id'], $row['id']);
        $this->assertEquals($expectedRow['status'], $row['status']);
        $this->assertEquals($expectedRow['name'], $row['name']);
        $this->assertEquals(
            $expectedRow['description'], $row['description']
        );
    }

    /**
     * Test edit action successful handling
     *
     * @group        controller
     * @group        category-backend
     */
    public function testEditActionSuccessfulHandling()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 1;
        $url = '/de/category-backend/edit/' . $id;

        $oldData = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        )->getRow(0);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $postArray = [
            'csrf'          => $this->getCsrfValue('category_form'),
            'name'          => 'Neue Firma',
            'description'   => str_repeat('description', 5),
            'save_category' => 'save_category',
        ];

        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters($postArray));

        $this->dispatch($url, 'POST');
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->assertRedirectTo($url);

        $queryCategory = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        );

        $row = $queryCategory->getRow(0);

        $expectedRow = [
            'id'          => $id,
            'status'      => $oldData['status'],
            'name'        => $postArray['name'],
            'description' => $postArray['description'],
        ];

        $this->assertEquals($expectedRow['id'], $row['id']);
        $this->assertEquals($expectedRow['status'], $row['status']);
        $this->assertEquals($expectedRow['name'], $row['name']);
        $this->assertEquals(
            $expectedRow['description'], $row['description']
        );
    }

    /**
     * Test delete action can be accessed
     *
     * @group        controller
     * @group        category-backend
     */
    public function testDeleteActionCanBeAccessed()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 1;
        $url = '/de/category-backend/delete/' . $id;

        $oldData = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        )->getRow(0);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName('category-backend/modify');
        $this->assertModuleName('categorybackend');
        $this->assertControllerName(ModifyController::class);
        $this->assertControllerClass('ModifyController');
        $this->assertActionName('delete');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            utf8_encode(
                $this->translator->translate(
                    'category_backend_h1_display_delete', 'default',
                    'de_DE'
                )
            )
        );

        $this->assertQueryContentRegex(
            'form .form-group .form-control-static',
            '#' . preg_quote($oldData['name']) . '#'
        );

        $queryCategory = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        );

        $this->assertEquals(1, $queryCategory->getRowCount());
    }

    /**
     * Test delete action successful handling
     *
     * @group        controller
     * @group        category-backend
     */
    public function testDeleteActionSuccessfulHandling()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 1;
        $url = '/de/category-backend/delete/' . $id . '?delete=yes';

        $queryCategory = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        );

        $this->assertEquals(1, $queryCategory->getRowCount());

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->assertRedirectTo('/de/category-backend');

        $queryCategory = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        );

        $this->assertEquals(0, $queryCategory->getRowCount());
    }

    /**
     * Test approve action can be accessed
     *
     * @group        controller
     * @group        category-backend
     */
    public function testApproveActionCanBeAccessed()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 12;
        $url = '/de/category-backend/approve/' . $id;

        $oldData = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        )->getRow(0);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName('category-backend/modify');
        $this->assertModuleName('categorybackend');
        $this->assertControllerName(ModifyController::class);
        $this->assertControllerClass('ModifyController');
        $this->assertActionName('approve');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            utf8_encode(
                $this->translator->translate(
                    'category_backend_h1_display_approve', 'default',
                    'de_DE'
                )
            )
        );

        $this->assertQueryContentRegex(
            'form .form-group .form-control-static',
            '#' . preg_quote($oldData['name']) . '#'
        );

        $queryCategory = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        );

        $this->assertEquals(1, $queryCategory->getRowCount());
    }

    /**
     * Test approve action successful handling
     *
     * @group        controller
     * @group        category-backend
     */
    public function testApproveActionSuccessfulHandling()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 12;
        $url = '/de/category-backend/approve/' . $id . '?approve=yes';

        $oldData = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        )->getRow(0);

        $this->assertEquals('new', $oldData['status']);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->assertRedirectTo('/de/category-backend/show/' . $id);

        $queryCategory = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        );

        $row = $queryCategory->getRow(0);

        $this->assertEquals('approved', $row['status']);
    }

    /**
     * Test block action can be accessed
     *
     * @group        controller
     * @group        category-backend
     */
    public function testBlockActionCanBeAccessed()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 12;
        $url = '/de/category-backend/block/' . $id;

        $oldData = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        )->getRow(0);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName('category-backend/modify');
        $this->assertModuleName('categorybackend');
        $this->assertControllerName(ModifyController::class);
        $this->assertControllerClass('ModifyController');
        $this->assertActionName('block');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            utf8_encode(
                $this->translator->translate(
                    'category_backend_h1_display_block', 'default', 'de_DE'
                )
            )
        );

        $this->assertQueryContentRegex(
            'form .form-group .form-control-static',
            '#' . preg_quote($oldData['name']) . '#'
        );

        $queryCategory = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        );

        $this->assertEquals(1, $queryCategory->getRowCount());
    }

    /**
     * Test block action successful handling
     *
     * @group        controller
     * @group        category-backend
     */
    public function testBlockActionSuccessfulHandling()
    {
        $this->mockLogin(AdminRole::NAME);

        $id  = 12;
        $url = '/de/category-backend/block/' . $id . '?block=yes';

        $oldData = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        )->getRow(0);

        $this->assertEquals('new', $oldData['status']);

        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->assertRedirectTo('/de/category-backend/show/' . $id);

        $queryCategory = $this->getConnection()->createQueryTable(
            'fetchCategoriesByPage',
            $this->generateQueryCategoryById($id)
        );

        $row = $queryCategory->getRow(0);

        $this->assertEquals('blocked', $row['status']);
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
