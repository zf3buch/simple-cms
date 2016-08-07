<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageBackendTest\Form;

use PageBackend\Form\PageForm;
use PHPUnit_Framework_TestCase;

/**
 * Class PageFormTest
 *
 * @package PageBackendTest\Form
 */
class PageFormTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group page-backend
     * @group form
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(PageForm::class));
    }
}
