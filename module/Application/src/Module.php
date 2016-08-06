<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Application;

use Application\I18n\I18nListener;
use Application\View\LayoutListener;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\ConfigInterface;

/**
 * Class Module
 *
 * @package Application
 */
class Module
{
    /**
     * @param ModuleManagerInterface $manager
     */
    public function init(ModuleManagerInterface $manager)
    {
        if (!defined('APPLICATION_MODULE_ROOT')) {
            define('APPLICATION_MODULE_ROOT', realpath(__DIR__ . '/../'));
        }
    }

    /**
     * @param EventInterface|MvcEvent $e
     */
    public function onBootstrap(EventInterface $e)
    {
        // get services
        $serviceManager = $e->getApplication()->getServiceManager();

        // add listeners
        $eventManager = $e->getApplication()->getEventManager();

        $layoutListener = new LayoutListener(['header', 'footer']);
        $layoutListener->attach($eventManager);

        /** @var I18nListener $i18nListener */
        $i18nListener = $serviceManager->get(I18nListener::class);
        $i18nListener->attach($eventManager);

        // start session config
        $sessionConfig = $serviceManager->get(ConfigInterface::class);
    }


    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include APPLICATION_MODULE_ROOT . '/config/module.config.php';
    }
}
