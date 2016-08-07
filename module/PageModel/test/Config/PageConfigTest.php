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

use PageModel\Config\PageConfig;
use PHPUnit_Framework_TestCase;

/**
 * Class PageConfigTest
 *
 * @package PageModelTest\Config
 */
class PageConfigTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group page-backend
     * @group model
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(PageConfig::class));
    }
}
