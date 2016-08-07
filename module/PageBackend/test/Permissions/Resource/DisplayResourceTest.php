<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageBackendTest\Permissions\Resource;

use PageBackend\Permissions\Resource\DisplayResource;
use PHPUnit_Framework_TestCase;

/**
 * Class DisplayResourceTest
 *
 * @package PageBackendTest\Permissions\Resource
 */
class DisplayResourceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group page-backend
     * @group permissions
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(DisplayResource::class));
    }
}
