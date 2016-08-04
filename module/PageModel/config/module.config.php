<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

use PageModel\Hydrator\PageHydrator;
use PageModel\Repository\PageRepositoryFactory;
use PageModel\Repository\PageRepositoryInterface;
use PageModel\Storage\Db\PageDbStorageFactory;
use PageModel\Storage\PageStorageInterface;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            PageStorageInterface::class => PageDbStorageFactory::class,

            PageRepositoryInterface::class => PageRepositoryFactory::class,
        ],
    ],

    'hydrators' => [
        'factories' => [
            PageHydrator::class => InvokableFactory::class,
        ],
    ],
];
