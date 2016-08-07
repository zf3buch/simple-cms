<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserModelTest\Storage\Db;

use UserModel\Storage\Db\UserDbStorage;
use PHPUnit_Framework_TestCase;

/**
 * Class UserDbStorageTest
 *
 * @package UserModelTest\Storage\Db
 */
class UserDbStorageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group user-model
     * @group model
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(UserDbStorage::class));
    }
}
