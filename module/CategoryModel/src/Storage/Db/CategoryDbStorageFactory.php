<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryModel\Storage\Db;

use CategoryModel\Entity\CategoryEntity;
use CategoryModel\Hydrator\CategoryHydrator;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class CategoryDbStorageFactory
 *
 * @package CategoryModel\Storage\Db
 */
class CategoryDbStorageFactory implements FactoryInterface
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
        /** @var AdapterInterface $dbAdapter */
        $dbAdapter = $container->get(Adapter::class);

        $resultSetPrototype = new HydratingResultSet(
            new CategoryHydrator(),
            new CategoryEntity()
        );

        $tableGateway = new TableGateway(
            'category', $dbAdapter, null, $resultSetPrototype
        );

        $storage = new CategoryDbStorage($tableGateway);

        return $storage;
    }
}
