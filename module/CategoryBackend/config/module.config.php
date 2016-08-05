<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

use CategoryBackend\Controller\DisplayController;
use CategoryBackend\Controller\DisplayControllerFactory;
use CategoryBackend\Controller\ModifyController;
use CategoryBackend\Controller\ModifyControllerFactory;
use CategoryBackend\Form\CategoryFormFactory;
use CategoryBackend\Form\CategoryFormInterface;
use Zend\Navigation\Page\Mvc;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'category_admin' => [
        'image_file_path'    => PROJECT_ROOT . '/public',
        'image_file_pattern' => '/categories/%s.jpg',
    ],

    'router' => [
        'routes' => [
            'category-backend' => [
                'type'          => Literal::class,
                'options'       => [
                    'route'    => '/category-backend',
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

    'view_manager' => [
        'template_map'        =>
            include CATEGORY_BACKEND_MODULE_ROOT
                . '/config/template_map.config.php',
        'template_path_stack' => [
            CATEGORY_BACKEND_MODULE_ROOT . '/view'
        ],
    ],

    'form_elements' => [
        'factories' => [
            CategoryFormInterface::class => CategoryFormFactory::class,
        ],
    ],

    'navigation' => [
        'default' => [
            'category-backend' => [
                'type'          => Mvc::class,
                'order'         => '950',
                'label'         => 'Kategorien administrieren',
                'route'         => 'category-backend',
                'controller'    => DisplayController::class,
                'action'        => 'index',
                'useRouteMatch' => true,
                'pages'         => [
                    'edit' => [
                        'type'    => Mvc::class,
                        'route'   => 'category-backend/modify',
                        'visible' => false,
                    ],
                    'show' => [
                        'type'    => Mvc::class,
                        'route'   => 'category-backend/show',
                        'visible' => false,
                    ],
                    'page' => [
                        'type'    => Mvc::class,
                        'route'   => 'category-backend/page',
                        'visible' => false,
                    ],
                ],
            ],
        ],
    ],
];
