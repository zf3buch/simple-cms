<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageModelTest\Config;

use PageModel\Config\PageConfigFactory;
use PHPUnit_Framework_TestCase;

/**
 * Class PageConfigFactoryTest
 *
 * @package PageModelTest\Config
 */
class PageConfigFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group page-model
     * @group model
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(PageConfigFactory::class));
    }
}
