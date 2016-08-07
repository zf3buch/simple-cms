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

use CategoryModel\Entity\CategoryEntity;
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
     * Get all categories for a given page
     *
     * @param int $page
     * @param int $count
     *
     * @return Paginator
     */
    public function getCategoriesByPage($page = 1, $count = 5)
    {
        return $this->categoryStorage->fetchCategoryCollection(
            $page, $count
        );
    }

    /**
     * Get a single category by id
     *
     * @param int $id
     *
     * @return array|bool
     */
    public function getSingleCategoryById($id)
    {
        return $this->categoryStorage->fetchCategoryEntityById($id);
    }

    /**
     * Get a single category by url
     *
     * @param string $url
     *
     * @return CategoryEntity|bool
     */
    public function getSingleCategoryByUrl($url)
    {
        return $this->categoryStorage->fetchCategoryEntityByUrl($url);
    }
}
