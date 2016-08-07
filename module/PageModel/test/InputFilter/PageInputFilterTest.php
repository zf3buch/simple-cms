<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageModelTest\InputFilter;

use PageModel\InputFilter\PageInputFilter;
use PHPUnit_Framework_TestCase;

/**
 * Class PageInputFilterTest
 *
 * @package PageModelTest\InputFilter
 */
class PageInputFilterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group page-model
     * @group model
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(PageInputFilter::class));
    }
}
