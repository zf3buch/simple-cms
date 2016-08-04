<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

use PageBackend\Controller\DisplayController;
use PageBackend\Controller\DisplayControllerFactory;
use PageBackend\Controller\ModifyController;
use PageBackend\Controller\ModifyControllerFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'page-backend' => [
                'type'          => Literal::class,
                'options'       => [
                    'route'    => '/page-backend',
                    'defaults' => [
                        'controller' => DisplayController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'modify' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'       => '/:action[/:id]',
                            'defaults'    => [
                                'controller' => ModifyController::class,
                            ],
                            'constraints' => [
                                'action' => '(add|edit|delete|approve|block)',
                                'id'     => '[1-9][0-9]*',
                            ],
                        ],
                    ],
                    'show'   => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'       => '/show[/:id]',
                            'defaults'    => [
                                'action' => 'show',
                            ],
                            'constraints' => [
                                'id' => '[1-9][0-9]*',
                            ],
                        ],
                    ],
                    'page'   => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'       => '/:page',
                            'constraints' => [
                                'page' => '[1-9][0-9]*',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            DisplayController::class => DisplayControllerFactory::class,
            ModifyController::class  => ModifyControllerFactory::class,
        ],
    ],
];
