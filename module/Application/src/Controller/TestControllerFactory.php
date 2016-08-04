<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace Application\Controller;

use PageModel\Storage\Db\PageDbStorage;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class TestControllerFactory
 *
 * @package Application\Controller
 */
class TestControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $pageDbStorage = $container->get(PageDbStorage::class);

        $controller = new TestController();
        $controller->setPageDbStorage($pageDbStorage);

        return $controller;
    }
}
