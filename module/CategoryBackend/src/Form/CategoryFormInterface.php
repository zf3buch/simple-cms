<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryBackend\Form;

use Zend\Form\FormInterface;

/**
 * Interface CategoryFormInterface
 *
 * @package CategoryBackend\Form
 */
interface CategoryFormInterface extends FormInterface
{
    /**
     * @param array $statusOptions
     */
    public function setStatusOptions($statusOptions);

    /**
     * Switch to add mode
     */
    public function addMode();

    /**
     * Switch to edit mode
     */
    public function editMode();

    /**
     * Add image file upload filter to input filter
     */
    public function addImageFileUploadFilter();
}
