<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserBackend\Form;

use UserModel\Config\UserConfigInterface;
use UserModel\Hydrator\UserHydrator;
use UserModel\InputFilter\UserInputFilter;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\HydratorPluginManager;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterPluginManager;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class UserFormFactory
 *
 * @package UserBackend\Form
 */
class UserFormFactory implements FactoryInterface
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
        /** @var HydratorPluginManager $hydratorManager */
        $hydratorManager = $container->get('HydratorManager');

        /** @var InputFilterPluginManager $inputFilterManager */
        $inputFilterManager = $container->get('InputFilterManager');

        /** @var UserHydrator $userHydrator */
        $userHydrator = $hydratorManager->get(UserHydrator::class);

        /** @var InputFilterInterface $userInputFilter */
        $userInputFilter = $inputFilterManager->get(
            UserInputFilter::class
        );

        /** @var UserConfigInterface $userConfig */
        $userConfig = $container->get(UserConfigInterface::class);

        $form = new UserForm();
        $form->setHydrator($userHydrator);
        $form->setInputFilter($userInputFilter);
        $form->setStatusOptions($userConfig->getStatusOptions());
        $form->setRoleOptions($userConfig->getRoleOptions());

        return $form;
    }
}
