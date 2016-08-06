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

/**
 * Interface UserConfigInterface
 *
 * @package UserModel\Config
 */
interface UserConfigInterface
{
    /**
     * Get the status options
     */
    public function getStatusOptions();
    
    /**
     * Get the role options
     */
    public function getRoleOptions();
}
