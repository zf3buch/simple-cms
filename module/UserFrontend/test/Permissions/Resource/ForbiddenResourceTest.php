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

use UserFrontend\Permissions\Resource\ForbiddenResource;
use PHPUnit_Framework_TestCase;

/**
 * Class ForbiddenResourceTest
 *
 * @package UserFrontendTest\Permissions\Resource
 */
class ForbiddenResourceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group user-frontend
     * @group permissions
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(ForbiddenResource::class));
    }
}
