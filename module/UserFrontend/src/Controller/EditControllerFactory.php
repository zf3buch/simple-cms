<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserFrontend\Controller;

use Interop\Container\ContainerInterface;
use UserFrontend\Form\UserEditForm;
use UserFrontend\Form\UserEditFormInterface;
use UserModel\Repository\UserRepositoryInterface;
use Zend\Form\FormElementManager\FormElementManagerTrait;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class EditControllerFactory
 *
 * @package UserFrontend\Controller
 */
class EditControllerFactory implements FactoryInterface
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
        /** @var FormElementManagerTrait $formElementManager */
        $formElementManager = $container->get('FormElementManager');

        $userRepository = $container->get(
            UserRepositoryInterface::class
        );

        /** @var UserEditFormInterface $userForm */
        $userForm = $formElementManager->get(UserEditForm::class);

        $controller = new EditController();
        $controller->setUserRepository($userRepository);
        $controller->setUserForm($userForm);

        return $controller;
    }
}
