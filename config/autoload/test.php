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
    'db'              => [
        'driver' => 'pdo',
        'dsn'    => 'mysql:dbname=simple-cms-test;host=localhost;charset=utf8',
        'user'   => 'simple-cms',
        'pass'   => 'geheim',
    ],
];
