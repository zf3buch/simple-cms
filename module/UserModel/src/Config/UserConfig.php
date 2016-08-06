<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserModel\Config;

use Zend\Config\Config;

/**
 * Class UserConfig
 *
 * @package UserModel\Config
 */
class UserConfig extends Config implements UserConfigInterface
{
    /**
     * Get the status options
     */
    public function getStatusOptions()
    {
        return $this->get('status_options')->toArray();
    }

    /**
     * Get the role options
     */
    public function getRoleOptions()
    {
        return $this->get('role_options')->toArray();
    }
}
