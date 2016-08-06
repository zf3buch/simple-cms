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

use Zend\Form\Element\Csrf;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

/**
 * Class PageForm
 *
 * @package PageBackend\Form
 */
class PageForm extends Form implements PageFormInterface
{
    /**
     * @var array
     */
    private $statusOptions;

    /**
     * @var array
     */
    private $categoryOptions;

    /**
     * @param array $statusOptions
     */
    public function setStatusOptions($statusOptions)
    {
        $this->statusOptions = $statusOptions;
    }

    /**
     * @param array $categoryOptions
     */
    public function setCategoryOptions($categoryOptions)
    {
        $this->categoryOptions = $categoryOptions;
    }

    /**
     * Init form
     */
    public function init()
    {
        $this->setName('page_form');
        $this->setAttribute('class', 'form-horizontal');

        $this->add(
            [
                'type' => Csrf::class,
                'name' => 'csrf',
            ]
        );

        $this->add(
            [
                'type'       => Select::class,
                'name'       => 'status',
                'attributes' => [
                    'class' => 'form-control',
                ],
                'options'    => [
                    'value_options' => $this->statusOptions,
                    'label'         => 'page_backend_label_status',
                ],
            ]
        );

        $this->add(
            [
                'type'       => Select::class,
                'name'       => 'category',
                'attributes' => [
                    'class' => 'form-control',
                ],
                'options'    => [
                    'value_options' => $this->categoryOptions,
                    'label'         => 'page_backend_label_category',
                ],
            ]
        );

        $this->add(
            [
                'type'       => Text::class,
                'name'       => 'author',
                'attributes' => [
                    'class' => 'form-control',
                ],
                'options'    => [
                    'label' => 'page_backend_label_author',
                ],
            ]
        );

        $this->add(
            [
                'type'       => Text::class,
                'name'       => 'title',
                'attributes' => [
                    'class' => 'form-control',
                ],
                'options'    => [
                    'label' => 'page_backend_label_title',
                ],
            ]
        );

        $this->add(
            [
                'type'       => Textarea::class,
                'name'       => 'text',
                'attributes' => [
                    'id'    => 'page_text',
                    'class' => 'form-control',
                ],
                'options'    => [
                    'label' => 'page_backend_label_text',
                ],
            ]
        );

        $this->add(
            [
                'type'       => Submit::class,
                'name'       => 'save_page',
                'options'    => [],
                'attributes' => [
                    'id'    => 'save_page',
                    'class' => 'btn btn-primary',
                    'value' => 'page_backend_action_save',
                ],
            ]
        );
    }

    /**
     * Switch to edit mode
     */
    public function editMode()
    {
        if ($this->has('status')) {
            $this->remove('status');
        }

        if ($this->has('category')) {
            $this->remove('category');
        }

        $this->setValidationGroup(array_keys($this->getElements()));
    }
}
