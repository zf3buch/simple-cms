<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserFrontend\Authentication;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;

/**
 * Class AuthenticationListener
 *
 * @package UserFrontend\Authentication
 */
interface AuthenticationListenerInterface
    extends ListenerAggregateInterface
{
    /**
     * Authenticate user
     *
     * @param MvcEvent $e
     */
    public function authenticate(MvcEvent $e);
}
