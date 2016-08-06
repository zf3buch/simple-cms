<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserFrontend\Authorization;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;

/**
 * Interface AuthorizationListenerInterface
 *
 * @package UserFrontend\Authorization
 */
interface AuthorizationListenerInterface extends ListenerAggregateInterface
{
    /**
     * Authorize user
     *
     * @param MvcEvent $e
     */
    public function authorize(MvcEvent $e);
}
