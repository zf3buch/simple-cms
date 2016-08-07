<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserBackendTest\Permissions\Resource;

use UserBackend\Permissions\Resource\DisplayResource;
use PHPUnit_Framework_TestCase;

/**
 * Class DisplayResourceTest
 *
 * @package UserBackendTest\Permissions\Resource
 */
class DisplayResourceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group user-backend
     * @group permissions
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(DisplayResource::class));
    }
}
