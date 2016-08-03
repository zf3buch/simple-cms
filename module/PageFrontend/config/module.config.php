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

return [
    'router' => [
        'routes' => [
            'page-frontend' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/page[/:url]',
                    'defaults' => [
                        'controller' => DisplayController::class,
                        'action'     => 'index',
                    ],
                    'constraints' => [
                        'url'     => '[a-z1-9-]*',
                    ],
                ],
            ],
        ],
    ],
];
