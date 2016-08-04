<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

use CategoryModel\Hydrator\CategoryHydrator;
use CategoryModel\Storage\CategoryStorageInterface;
use CategoryModel\Storage\Db\CategoryDbStorageFactory;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            CategoryStorageInterface::class => CategoryDbStorageFactory::class,
        ],
    ],

    'hydrators' => [
        'factories' => [
            CategoryHydrator::class => InvokableFactory::class,
        ],
    ],
];
