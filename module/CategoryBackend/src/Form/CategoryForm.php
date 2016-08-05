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

use CategoryModel\Filter\ImageFileUpload;
use TravelloFilter\Filter\StringToUrlSlug;
use Zend\Filter\StaticFilter;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\File;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

/**
 * Class CategoryForm
 *
 * @package CategoryBackend\Form
 */
class CategoryForm extends Form implements CategoryFormInterface
{
    /**
     * @var array
     */
    private $statusOptions;

    /**
     * @var string
     */
    private $imageFilePath;

    /**
     * @var string
     */
    private $imageFilePattern;

    /**
     * @param array $statusOptions
     */
    public function setStatusOptions($statusOptions)
    {
        $this->statusOptions = $statusOptions;
    }

    /**
     * @param string $imageFilePath
     */
    public function setImageFilePath($imageFilePath)
    {
        $this->imageFilePath = $imageFilePath;
    }

    /**
     * @param string $imageFilePattern
     */
    public function setImageFilePattern($imageFilePattern)
    {
        $this->imageFilePattern = $imageFilePattern;
    }

    /**
     * Init form
     */
    public function init()
    {
        $this->setName('category_form');
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
                    'value_options'    => $this->statusOptions,
                    'label'            => 'Status',
                    'label_attributes' => [
                        'class' => 'col-sm-2 control-label',
                    ],
                ],
            ]
        );

        $this->add(
            [
                'type'       => Text::class,
                'name'       => 'name',
                'attributes' => [
                    'class' => 'form-control',
                ],
                'options'    => [
                    'label'            => 'Kategoriename',
                    'label_attributes' => [
                        'class' => 'col-sm-2 control-label',
                    ],
                ],
            ]
        );

        $this->add(
            [
                'type'       => Textarea::class,
                'name'       => 'description',
                'attributes' => [
                    'id'    => 'category_description',
                    'class' => 'form-control',
                ],
                'options'    => [
                    'label'            => 'Beschreibung',
                    'label_attributes' => [
                        'class' => 'col-sm-2 control-label',
                    ],
                ],
            ]
        );

        $this->add(
            [
                'type'       => File::class,
                'name'       => 'image',
                'attributes' => [
                    'class' => 'form-control-static',
                ],
                'options'    => [
                    'label'            => 'Bild',
                    'label_attributes' => [
                        'class' => 'col-sm-2 control-label',
                    ],
                ],
            ]
        );

        $this->add(
            [
                'type'       => Submit::class,
                'name'       => 'save_category',
                'options'    => [],
                'attributes' => [
                    'id'    => 'save_category',
                    'class' => 'btn btn-primary',
                    'value' => 'Kategorie speichern',
                ],
            ]
        );
    }

    /**
     * Switch to add mode
     */
    public function addMode()
    {
        if ($this->has('image')) {
            $this->remove('image');
        }

        $this->setValidationGroup(array_keys($this->getElements()));
    }

    /**
     * Switch to edit mode
     */
    public function editMode()
    {
        if ($this->has('status')) {
            $this->remove('status');
        }

        $this->setValidationGroup(array_keys($this->getElements()));
    }

    /**
     * Add image file upload filter to input filter
     */
    public function addImageFileUploadFilter()
    {
        $nameValue = $this->get('name')->getValue();

        $targetFile = sprintf(
            $this->imageFilePattern,
            StaticFilter::execute($nameValue, StringToUrlSlug::class)
        );

        $imageFileUploadFilter = new ImageFileUpload(
            $this->imageFilePath, $targetFile
        );

        $this->getInputFilter()->get('image')->getFilterChain()->attach(
            $imageFileUploadFilter
        );
    }
}
