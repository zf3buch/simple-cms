<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

return [
    'modules'                 => [
        'Zend\Mvc\Plugin\Identity',
        'TravelloFilter',
        'TravelloViewHelper',
        'Zend\Mvc\I18n',
        'Zend\Mvc\Plugin\FlashMessenger',
        'Zend\I18n',
        'Zend\Form',
        'Zend\InputFilter',
        'Zend\Db',
        'Zend\Filter',
        'Zend\Hydrator',
        'Zend\Paginator',
        'Zend\Navigation',
        'Zend\Session',
        'Zend\Router',
        'Zend\Validator',
        'UserFrontend',
        'UserBackend',
        'UserModel',
        'CategoryBackend',
        'CategoryModel',
        'PageFrontend',
        'PageBackend',
        'PageModel',
        'Application',
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            PROJECT_ROOT
            . '/config/autoload/{,*.}{global,test,local}.php',
        ],
        'module_paths'             => [
            PROJECT_ROOT . '/module',
            PROJECT_ROOT . '/vendor',
        ],
        'cache_dir'                => PROJECT_ROOT . '/data/cache',
        'config_cache_enabled'     => false,
        'config_cache_key'         => 'application.config.cache',
        'module_map_cache_enabled' => false,
        'module_map_cache_key'     => 'application.module.cache',
    ],
];
