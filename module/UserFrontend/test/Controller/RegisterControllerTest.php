<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserFrontendTest\Controller;

use Application\Test\HttpControllerTestCaseTrait;
use UserFrontend\Controller\RegisterController;
use UserModel\Permissions\Role\EditorRole;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class RegisterControllerTest
 *
 * @package UserFrontendTest\Controller
 */
class RegisterControllerTest extends AbstractHttpControllerTestCase
{
    use HttpControllerTestCaseTrait;

    /**
     * @var array
     */
    protected $csvTables = [];

    /**
     * Test index action can be access
     *
     * @param $url
     * @param $locale
     * @param $route
     *
     * @group        controller
     * @group        user-frontend
     * @dataProvider provideIndexActionCanBeAccessed
     */
    public function testIndexActionCanBeAccessed(
        $url, $locale, $route
    ) {
        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName($route);
        $this->assertModuleName('userfrontend');
        $this->assertControllerName(RegisterController::class);
        $this->assertControllerClass('RegisterController');
        $this->assertActionName('index');

        $this->assertQuery('.page-header h1');
        $this->assertQueryContentContains(
            '.page-header h1',
            $this->translator->translate(
                'user_frontend_h1_register_index', 'default', $locale
            )
        );

        $this->assertFormElementsExist(
            'user_register_form',
            [
                'csrf', 'email', 'password', 'register_user'
            ]
        );

        $this->assertFormElementValues(
            'user_register_form',
            [
                'email' => '',
                'password' => '',
            ]
        );
    }

    /**
     * @return array
     */
    public function provideIndexActionCanBeAccessed()
    {
        return [
            ['/de/user/register', 'de_DE', 'user-frontend/register'],
            ['/en/user/register', 'en_US', 'user-frontend/register'],
        ];
    }
}
