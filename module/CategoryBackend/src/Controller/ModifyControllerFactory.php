<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryBackend\Controller;

use CategoryModel\Repository\CategoryRepositoryInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ModifyControllerFactory
 *
 * @package CategoryBackend\Controller
 */
class ModifyControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null|null    $options
     *
     * @return mixed
     */
    public function __invoke(
        ContainerInterface $container, $requestedName,
        array $options = null
    ) {
        $categoryRepository = $container->get(
            CategoryRepositoryInterface::class
        );

        $controller = new ModifyController();
        $controller->setCategoryRepository($categoryRepository);

        return $controller;
    }
}
