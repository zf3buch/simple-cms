<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 */

return [
    'modules' => [
        'Zend\Mvc\I18n',
        'TravelloViewHelper',
        'Zend\Mvc\Plugin\FlashMessenger',
        'Zend\I18n',
        'Zend\Form',
        'Zend\InputFilter',
        'TravelloFilter',
        'Zend\Db',
        'Zend\Filter',
        'Zend\Hydrator',
        'Zend\Navigation',
        'Zend\Paginator',
        'Zend\Session',
        'Zend\Router',
        'Zend\Validator',
        'PageFrontend',
        'PageBackend',
        'PageModel',
        'CategoryModel',
        'CategoryBackend',
        'Application',
    ],
    'module_listener_options' => [
        'module_paths' => [
            PROJECT_ROOT . '/module',
            PROJECT_ROOT . '/vendor',
        ],
        'cache_dir'                => PROJECT_ROOT . '/data/cache',
        'config_cache_enabled'     => true,
        'config_cache_key'         => 'application.config.cache',
        'module_map_cache_enabled' => true,
        'module_map_cache_key'     => 'application.module.cache',
    ],
];
