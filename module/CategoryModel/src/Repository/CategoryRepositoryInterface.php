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
use Zend\Paginator\Paginator;

/**
 * Interface CategoryRepositoryInterface
 *
 * @package CategoryModel\Repository
 */
interface CategoryRepositoryInterface
{
    /**
     * Get all companies for a given page
     *
     * @param int $page
     * @param int $count
     *
     * @return Paginator
     */
    public function getCompaniesByPage($page = 1, $count = 5);

    /**
     * Get a single category by id
     *
     * @param int $id
     *
     * @return CategoryEntity|bool
     */
    public function getSingleCategoryById($id);

    /**
     * Get a single category by url
     *
     * @param string $url
     *
     * @return CategoryEntity|bool
     */
    public function getSingleCategoryByUrl($url);
}
