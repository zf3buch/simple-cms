<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryModel\Repository;

use CategoryModel\Storage\CategoryStorageInterface;
use Zend\Paginator\Paginator;

/**
 * Class CategoryRepository
 *
 * @package CategoryModel\Repository
 */
class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @var CategoryStorageInterface
     */
    private $categoryStorage;

    /**
     * CategoryRepository constructor.
     *
     * @param CategoryStorageInterface $categoryStorage
     */
    public function __construct(CategoryStorageInterface $categoryStorage)
    {
        $this->categoryStorage = $categoryStorage;
    }

    /**
     * Get all companies for a given page
     *
     * @param int $page
     * @param int $count
     *
     * @return Paginator
     */
    public function getCompaniesByPage($page = 1, $count = 5)
    {
        return $this->categoryStorage->fetchCategoryCollection(
            $page, $count
        );
    }

    /**
     * Get a single category by id
     *
     * @param $id
     *
     * @return array|bool
     */
    public function getSingleCategoryById($id)
    {
        return $this->categoryStorage->fetchCategoryEntity($id);
    }
}
