<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

use PageFrontend\Controller\DisplayController;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'category' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/category[/:url]',
                    'defaults'    => [
                        'controller' => DisplayController::class,
                        'action'     => 'category',
                    ],
                    'constraints' => [
                        'url' => '[a-z1-9-]*',
                    ],
                ],
            ],
            'page'     => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/page[/:url]',
                    'defaults'    => [
                        'controller' => DisplayController::class,
                        'action'     => 'page',
                    ],
                    'constraints' => [
                        'url' => '[a-z1-9-]*',
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            DisplayController::class => InvokableFactory::class,
        ],
    ],
];
