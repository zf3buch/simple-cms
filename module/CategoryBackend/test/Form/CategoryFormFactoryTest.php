<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryBackendTest\Form;

use CategoryBackend\Form\CategoryFormFactory;
use PHPUnit_Framework_TestCase;

/**
 * Class CategoryFormFactoryTest
 *
 * @package CategoryBackendTest\Form
 */
class CategoryFormFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group category-backend
     * @group form
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(CategoryFormFactory::class));
    }
}
