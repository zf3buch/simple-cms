<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageFrontend\Controller;

use CategoryModel\Repository\CategoryRepositoryInterface;
use Interop\Container\ContainerInterface;
use PageModel\Repository\PageRepositoryInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class DisplayControllerFactory
 *
 * @package PageFrontend\Controller
 */
class DisplayControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $pageRepository     = $container->get(
            PageRepositoryInterface::class
        );
        $categoryRepository = $container->get(
            CategoryRepositoryInterface::class
        );

        $controller = new DisplayController();
        $controller->setPageRepository($pageRepository);
        $controller->setCategoryRepository($categoryRepository);

        return $controller;
    }
}
