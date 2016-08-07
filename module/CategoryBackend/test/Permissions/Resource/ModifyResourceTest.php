<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryBackendTest\Permissions\Resource;

use CategoryBackend\Permissions\Resource\ModifyResource;
use PHPUnit_Framework_TestCase;

/**
 * Class ModifyResourceTest
 *
 * @package CategoryBackendTest\Permissions\Resource
 */
class ModifyResourceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group category-backend
     * @group permissions
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(ModifyResource::class));
    }
}
