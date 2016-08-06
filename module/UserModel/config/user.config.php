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
    'status_options' => [
        'new'      => 'user_model_option_status_new',
        'approved' => 'user_model_option_status_approved',
        'blocked'  => 'user_model_option_status_blocked',
    ],
    'role_options'   => [
        'editor' => 'user_model_option_role_editor',
        'admin'  => 'user_model_option_role_admin',
    ],
];
