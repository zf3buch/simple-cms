<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Application;

use Application\Controller\IndexController;
use Application\Controller\IndexControllerFactory;
use Application\I18n\I18nListener;
use Application\I18n\I18nListenerFactory;
use Zend\Navigation\Page\Mvc;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/[:lang]',
                    'defaults'    => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                        'lang'       => 'de',
                    ],
                    'constraints' => [
                        'lang' => '(de|en)',
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class,
        ],
    ],

    'service_manager' => [
        'factories' => [
            I18nListener::class => I18nListenerFactory::class,
        ],
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             =>
            include APPLICATION_MODULE_ROOT
                . '/config/template_map.config.php',
        'template_path_stack'      => [
            APPLICATION_MODULE_ROOT . '/view',
        ],
    ],

    'i18n' => [
        'defaultLang'    => 'de',
        'allowedLocales' => [
            'de' => 'de_DE',
            'en' => 'en_US',
        ],
        'defaultRoute'   => 'home',
    ],

    'navigation' => [
        'default' => [
            'application' => [
                'type'          => Mvc::class,
                'order'         => '100',
                'label'         => 'Startseite',
                'route'         => 'home',
                'controller'    => IndexController::class,
                'action'        => 'index',
                'useRouteMatch' => true,
            ],
        ],
    ],
];
