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

use PageBackend\Form\PageFormFactory;
use PHPUnit_Framework_TestCase;

/**
 * Class PageFormFactoryTest
 *
 * @package PageBackendTest\Form
 */
class PageFormFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group page-backend
     * @group form
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(PageFormFactory::class));
    }
}
