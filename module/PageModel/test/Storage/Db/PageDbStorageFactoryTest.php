<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageModelTest\Storage\Db;

use PageModel\Storage\Db\PageDbStorageFactory;
use PHPUnit_Framework_TestCase;

/**
 * Class PageDbStorageFactoryTest
 *
 * @package PageModelTest\Storage\Db
 */
class PageDbStorageFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group page-model
     * @group model
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(PageDbStorageFactory::class));
    }
}
