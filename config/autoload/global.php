<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 */

use Zend\Db\Adapter\AdapterServiceFactory;

return [
    'service_manager' => [
        'factories' => [
            Zend\Db\Adapter\Adapter::class => AdapterServiceFactory::class,
        ],
    ],

    'session_config' => [
        'save_path'       => realpath(PROJECT_ROOT . '/data/session'),
        'name'            => 'ZFC_SESSION',
        'cookie_lifetime' => 365 * 24 * 60 * 60,
        'gc_maxlifetime'  => 720,
    ],
];
