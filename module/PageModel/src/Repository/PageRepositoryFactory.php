<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageModel\Repository;

use Interop\Container\ContainerInterface;
use PageModel\Storage\Db\PageDbStorage;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class PageRepositoryFactory
 *
 * @package PageModel\Repository
 */
class PageRepositoryFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $pageDbStorage = $container->get(PageDbStorage::class);

        return new PageRepository($pageDbStorage);
    }
}
