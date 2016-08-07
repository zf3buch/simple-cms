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

use UserFrontend\Permissions\Resource\EditResource;
use PHPUnit_Framework_TestCase;

/**
 * Class EditResourceTest
 *
 * @package UserFrontendTest\Permissions\Resource
 */
class EditResourceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group advert-backend
     * @group permissions
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(EditResource::class));
    }
}
