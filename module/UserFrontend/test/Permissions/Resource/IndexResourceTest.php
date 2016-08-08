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

use UserFrontend\Permissions\Resource\IndexResource;
use PHPUnit_Framework_TestCase;

/**
 * Class IndexResourceTest
 *
 * @package UserFrontendTest\Permissions\Resource
 */
class IndexResourceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group user-frontend
     * @group permissions
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(IndexResource::class));
    }
}