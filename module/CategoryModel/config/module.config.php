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
use CategoryModel\Repository\CategoryRepositoryFactory;
use CategoryModel\Repository\CategoryRepositoryInterface;
use CategoryModel\Storage\Db\CategoryDbStorage;
use CategoryModel\Storage\Db\CategoryDbStorageFactory;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            CategoryDbStorage::class => CategoryDbStorageFactory::class,

            CategoryRepositoryInterface::class =>
                CategoryRepositoryFactory::class
        ],
    ],
    
    'hydrators' => [
        'factories' => [
            CategoryHydrator::class => InvokableFactory::class,
        ],
    ],
];
