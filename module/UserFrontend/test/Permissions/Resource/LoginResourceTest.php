<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserFrontendTest\Permissions\Resource;

use UserFrontend\Permissions\Resource\LoginResource;
use PHPUnit_Framework_TestCase;

/**
 * Class LoginResourceTest
 *
 * @package UserFrontendTest\Permissions\Resource
 */
class LoginResourceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group advert-backend
     * @group permissions
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(LoginResource::class));
    }
}
