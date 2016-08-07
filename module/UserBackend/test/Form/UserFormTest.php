<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserBackendTest\Form;

use UserBackend\Form\UserForm;
use PHPUnit_Framework_TestCase;

/**
 * Class UserFormTest
 *
 * @package UserBackendTest\Form
 */
class UserFormTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group user-backend
     * @group form
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(UserForm::class));
    }
}
