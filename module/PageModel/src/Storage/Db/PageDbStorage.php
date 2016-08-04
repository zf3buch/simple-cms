<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageModel\Storage\Db;

use PageModel\Entity\PageEntity;
use PageModel\Storage\PageStorageInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Hydrator\HydratorInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

/**
 * Class PageDbStorage
 *
 * @package PageModel\Storage\Db
 */
class PageDbStorage implements PageStorageInterface
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
     * PageDbStorage constructor.
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
     * Fetch an page collection by type from storage
     *
     * @param int $page
     * @param int $count
     *
     * @return Paginator
     */
    public function fetchPageCollection($page = 1, $count = 5)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->order(['page.created' => 'DESC']);

        $select = $this->addCategoryJoinToSelect($select);

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
     * Fetch an page collection by type from storage
     *
     * @param string $url
     * @param bool   $approved
     *
     * @return Paginator
     */
    public function fetchPageCollectionByCategory($url, $approved = true)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where->equalTo('category_url', $url);
        $select->order(['page.created' => 'DESC']);

        $select = $this->addCategoryJoinToSelect($select);

        $dbSelectAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter(),
            $this->tableGateway->getResultSetPrototype()
        );

        $paginator = new Paginator($dbSelectAdapter);

        return $paginator;
    }

    /**
     * Fetch random pages
     *
     * @param int $count
     *
     * @return Paginator
     */
    public function fetchRandomPageCollection($count = 4)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where->equalTo('page.status', 'approved');
        $select->order(new Expression('RAND()'));
        $select->limit($count);

        $select = $this->addCategoryJoinToSelect($select);

        $dbSelectAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter(),
            $this->tableGateway->getResultSetPrototype()
        );

        $paginator = new Paginator($dbSelectAdapter);

        return $paginator;
    }

    /**
     * Fetch an page entity by id from storage
     *
     * @param int $id
     *
     * @return PageEntity
     */
    public function fetchPageEntityById($id)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where->equalTo('page.id', $id);

        $select = $this->addCategoryJoinToSelect($select);

        /** @var ResultSet $resultSet */
        $resultSet = $this->tableGateway->selectWith($select);

        return $resultSet->current();
    }

    /**
     * Fetch an page entity by url from storage
     *
     * @param string $url
     *
     * @return PageEntity
     */
    public function fetchPageEntityByUrl($url)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where->equalTo('page.url', $url);

        $select = $this->addCategoryJoinToSelect($select);

        /** @var ResultSet $resultSet */
        $resultSet = $this->tableGateway->selectWith($select);

        return $resultSet->current();
    }

    /**
     * Insert new page entity to storage
     *
     * @param PageEntity $page
     *
     * @return mixed
     */
    public function insertPage(PageEntity $page)
    {
        $insertData = $this->hydrator->extract($page);

        $insert = $this->tableGateway->getSql()->insert();
        $insert->values($insertData);

        return $this->tableGateway->insertWith($insert) > 0;
    }

    /**
     * Update existing page entity in storage
     *
     * @param PageEntity $page
     *
     * @return mixed
     */
    public function updatePage(PageEntity $page)
    {
        $updateData = $this->hydrator->extract($page);

        $update = $this->tableGateway->getSql()->update();
        $update->set($updateData);
        $update->where->equalTo('id', $page->getId());

        return $this->tableGateway->updateWith($update) > 0;
    }

    /**
     * Delete existing page entity from storage
     *
     * @param PageEntity $page
     *
     * @return mixed
     */
    public function deletePage(PageEntity $page)
    {
        $delete = $this->tableGateway->getSql()->delete();
        $delete->where->equalTo('id', $page->getId());

        return $this->tableGateway->deleteWith($delete) > 0;
    }

    /**
     * Add category join to select
     *
     * @param Select $select
     *
     * @return Select
     */
    private function addCategoryJoinToSelect(Select $select)
    {
        $select->join(
            'category',
            'page.category = category.id',
            [
                'category_id'          => 'id',
                'category_updated'     => 'updated',
                'category_status'      => 'status',
                'category_name'        => 'name',
                'category_url'         => 'url',
                'category_description' => 'description',
                'category_image'       => 'image',
            ]
        );

        return $select;
    }
}
