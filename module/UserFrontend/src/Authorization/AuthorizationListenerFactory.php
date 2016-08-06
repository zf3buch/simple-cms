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

use Interop\Container\ContainerInterface;
use UserModel\Permissions\UserAcl;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\View\Helper\Navigation;

/**
 * Class AuthorizationListenerFactory
 *
 * @package UserFrontend\Authorization
 */
class AuthorizationListenerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null|null    $options
     *
     * @return mixed
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $viewHelperManager = $container->get('ViewHelperManager');

        $authService      = $container->get(AuthenticationService::class);
        $userAcl          = $container->get(UserAcl::class);
        $navigationHelper = $viewHelperManager->get(Navigation::class);

        $authorizationListener = new AuthorizationListener(
            $authService, $userAcl, $navigationHelper
        );

        return $authorizationListener;
    }
}
