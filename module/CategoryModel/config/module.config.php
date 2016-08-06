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
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'hydrators' => [
        'factories' => [
            CategoryHydrator::class => InvokableFactory::class,
        ],
    ],
];