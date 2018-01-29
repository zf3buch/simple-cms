<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserModelTest\Permissions;

use UserModel\Permissions\UserAclFactory;
use PHPUnit_Framework_TestCase;

/**
 * Class UserAclFactoryTest
 *
 * @package UserModelTest\Permissions
 */
class UserAclFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group user-model
     * @group model
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(UserAclFactory::class));
    }
}