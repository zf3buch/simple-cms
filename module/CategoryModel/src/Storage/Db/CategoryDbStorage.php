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
use CategoryModel\Storage\CategoryStorageInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Hydrator\HydratorInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

/**
 * Class CategoryDbStorage
 *
 * @package CategoryModel\Storage\Db
 */
class CategoryDbStorage implements CategoryStorageInterface
{
    /**
     * @var TableGatewayInterface|TableGateway
     */
    private $tableGateway;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * CategoryDbStorage constructor.
     *
     * @param TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;

        /** @var HydratingResultSet $resultSetPrototype */
        $resultSetPrototype = $this->tableGateway->getResultSetPrototype();

        $this->hydrator = $resultSetPrototype->getHydrator();
    }

    /**
     * Fetch an category collection by type from storage
     *
     * @param int $page
     * @param int $count
     *
     * @return Paginator
     */
    public function fetchCategoryCollection($page = 1, $count = 5)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->order(['name' => 'ASC']);

        $dbSelectAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter(),
            $this->tableGateway->getResultSetPrototype()
        );

        $paginator = new Paginator($dbSelectAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($count);

        return $paginator;
    }

    /**
     * Fetch an category entity by id from storage
     *
     * @param $id
     *
     * @return CategoryEntity
     */
    public function fetchCategoryEntity($id)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where->equalTo('id', $id);

        /** @var ResultSet $resultSet */
        $resultSet = $this->tableGateway->selectWith($select);

        return $resultSet->current();
    }

    /**
     * Insert new category entity to storage
     *
     * @param CategoryEntity $category
     *
     * @return mixed
     */
    public function insertCategory(CategoryEntity $category)
    {
        $insertData = $this->hydrator->extract($category);

        $insert = $this->tableGateway->getSql()->insert();
        $insert->values($insertData);

        return $this->tableGateway->insertWith($insert) > 0;
    }

    /**
     * Update existing category entity in storage
     *
     * @param CategoryEntity $category
     *
     * @return mixed
     */
    public function updateCategory(CategoryEntity $category)
    {
        $updateData = $this->hydrator->extract($category);

        $update = $this->tableGateway->getSql()->update();
        $update->set($updateData);
        $update->where->equalTo('id', $category->getId());

        return $this->tableGateway->updateWith($update) > 0;
    }

    /**
     * Delete existing category entity from storage
     *
     * @param CategoryEntity $category
     *
     * @return mixed
     */
    public function deleteCategory(CategoryEntity $category)
    {
        $delete = $this->tableGateway->getSql()->delete();
        $delete->where->equalTo('id', $category->getId());

        return $this->tableGateway->deleteWith($delete) > 0;
    }
}
