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
use DateTime;
use TravelloFilter\Filter\StringToUrlSlug;
use Zend\Filter\StaticFilter;
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

    /**
     * Get category options
     *
     * @return array
     */
    public function getCategoryOptions()
    {
        return $this->categoryStorage->fetchCategoryOptions();
    }

    /**
     * Create a new category based on array data
     *
     * @param array $data
     *
     * @return CategoryEntity
     */
    public function createCategoryFromData(array $data = [])
    {
        $nextId = $this->categoryStorage->nextId();

        $url = StaticFilter::execute(
            $data['name'], StringToUrlSlug::class
        );

        $category = new CategoryEntity();
        $category->setId($nextId);
        $category->setUpdated(new DateTime());
        $category->setStatus($data['status']);
        $category->setName($data['name']);
        $category->setUrl($url);
        $category->setDescription($data['description']);

        return $category;
    }

    /**
     * Save category
     *
     * @param CategoryEntity $category
     *
     * @return boolean
     */
    public function saveCategory(CategoryEntity $category)
    {
        if (!$category->getId()) {
            return $this->categoryStorage->insertCategory($category);
        } else {
            return $this->categoryStorage->updateCategory($category);
        }
    }

    /**
     * Delete an category
     *
     * @param CategoryEntity $category
     *
     * @return boolean
     */
    public function deleteCategory(CategoryEntity $category)
    {
        return $this->categoryStorage->deleteCategory($category);
    }
}
