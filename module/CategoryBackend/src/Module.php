<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryBackend;

use Zend\Config\Factory;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;

/**
 * Class Module
 *
 * @package CategoryBackend
 */
class Module implements ConfigProviderInterface, InitProviderInterface
{
    /**
     * Initialize module
     *
     * @param ModuleManagerInterface $manager
     */
    public function init(ModuleManagerInterface $manager)
    {
        if (!defined('CATEGORY_BACKEND_MODULE_ROOT')) {
            define('CATEGORY_BACKEND_MODULE_ROOT', __DIR__ . '/../');
        }
    }

    /**
     * Get module configuration
     */
    public function getConfig()
    {
        return Factory::fromFile(
            CATEGORY_BACKEND_MODULE_ROOT . '/config/module.config.php'
        );
    }
}
