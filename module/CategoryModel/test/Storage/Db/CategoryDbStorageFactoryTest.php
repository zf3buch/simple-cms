<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryModelTest\Storage\Db;

use CategoryModel\Storage\Db\CategoryDbStorageFactory;
use PHPUnit_Framework_TestCase;

/**
 * Class CategoryDbStorageFactoryTest
 *
 * @package CategoryModelTest\Storage\Db
 */
class CategoryDbStorageFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group category-model
     * @group model
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(CategoryDbStorageFactory::class));
    }
}
