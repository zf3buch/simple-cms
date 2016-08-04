<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageBackend\Form;

use Zend\Form\FormInterface;

/**
 * Interface PageFormInterface
 *
 * @package PageBackend\Form
 */
interface PageFormInterface extends FormInterface
{
    /**
     * @param array $statusOptions
     */
    public function setStatusOptions($statusOptions);

    /**
     * @param array $categoryOptions
     */
    public function setCategoryOptions($categoryOptions);

    /**
     * Switch to edit mode
     */
    public function editMode();
}
