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
use PageFrontend\Controller\DisplayControllerFactory;
use Zend\Navigation\Page\Mvc;
use Zend\Router\Http\Segment;

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
            DisplayController::class => DisplayControllerFactory::class,
        ],
    ],

    'view_manager' => [
        'template_map'        =>
            include PAGE_FRONTEND_MODULE_ROOT . '/config/template_map.config.php',
        'template_path_stack' => [
            PAGE_FRONTEND_MODULE_ROOT . '/view'
        ],
    ],

    'navigation' => [
        'default' => [
            'category'     => [
                'type'          => Mvc::class,
                'order'         => '200',
                'label'         => 'Seiten',
                'route'         => 'category',
                'controller'    => DisplayController::class,
                'action'        => 'category',
                'useRouteMatch' => true,
                'pages'         => [
                    'page' => [
                        'type'    => Mvc::class,
                        'route'   => 'page',
                        'visible' => false,
                    ],
                ],
            ],
        ],
    ],
];
