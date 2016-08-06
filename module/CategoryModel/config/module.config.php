<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

use CategoryModel\Config\CategoryConfigFactory;
use CategoryModel\Config\CategoryConfigInterface;
use CategoryModel\Hydrator\CategoryHydrator;
use CategoryModel\InputFilter\CategoryInputFilter;
use CategoryModel\InputFilter\CategoryInputFilterFactory;
use CategoryModel\Repository\CategoryRepositoryFactory;
use CategoryModel\Repository\CategoryRepositoryInterface;
use CategoryModel\Storage\CategoryStorageInterface;
use CategoryModel\Storage\Db\CategoryDbStorageFactory;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            CategoryConfigInterface::class => CategoryConfigFactory::class,

            CategoryStorageInterface::class =>
                CategoryDbStorageFactory::class,

            CategoryRepositoryInterface::class =>
                CategoryRepositoryFactory::class
        ],
    ],

    'hydrators' => [
        'factories' => [
            CategoryHydrator::class => InvokableFactory::class,
        ],
    ],

    'input_filters' => [
        'factories' => [
            CategoryInputFilter::class =>
                CategoryInputFilterFactory::class,
        ],
    ],

    'translator' => [
        'translation_file_patterns' => [
            [
                'type'     => 'phparray',
                'base_dir' => CATEGORY_MODEL_MODULE_ROOT . '/language',
                'pattern'  => '%s.php',
            ],
        ],
    ],
];
