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
    'service_manager' => [
        'factories' => [
            PageModel\Repository\PageRepositoryInterface::class =>
                PageModel\Repository\PageRepositoryFactory::class
        ],
    ],
];
