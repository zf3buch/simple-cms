<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryModel\Storage;

use CategoryModel\Entity\CategoryEntity;
use Zend\Paginator\Paginator;

/**
 * Interface CategoryStorageInterface
 *
 * @package CategoryModel\Storage
 */
interface CategoryStorageInterface
{
    /**
     * Fetch an category collection by type from storage
     *
     * @param int $page
     * @param int $count
     *
     * @return Paginator
     */
    public function fetchCategoryCollection($page = 1, $count = 5);

    /**
     * Fetch an category entity by id from storage
     *
     * @param integer $id
     *
     * @return CategoryEntity
     */
    public function fetchCategoryEntityById($id);

    /**
     * Fetch an category entity by url from storage
     *
     * @param string $url
     *
     * @return CategoryEntity
     */
    public function fetchCategoryEntityByUrl($url);

    /**
     * Fetch all categories for an option list
     *
     * @return mixed
     */
    public function fetchCategoryOptions();

    /**
     * Get next id for category entity
     *
     * @return integer
     */
    public function nextId();

    /**
     * Insert new category entity to storage
     *
     * @param CategoryEntity $category
     *
     * @return mixed
     */
    public function insertCategory(CategoryEntity $category);

    /**
     * Update existing category entity in storage
     *
     * @param CategoryEntity $category
     *
     * @return mixed
     */
    public function updateCategory(CategoryEntity $category);

    /**
     * Delete existing category entity from storage
     *
     * @param CategoryEntity $category
     *
     * @return mixed
     */
    public function deleteCategory(CategoryEntity $category);
}