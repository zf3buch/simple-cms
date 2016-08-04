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

/**
 * Interface PageRepositoryInterface
 *
 * @package PageModel\Repository
 */
interface PageRepositoryInterface
{
    /**
     * Get all pages for a given page
     *
     * @param int         $page
     * @param int         $count
     *
     * @return mixed
     */
    public function getPagesByPage($page = 1, $count = 5);

    /**
     * Get all pages for a given category
     *
     * @param string $url
     * @param bool   $approved
     *
     * @return mixed
     */
    public function getPagesByCategory($url, $approved = true);

    /**
     * Get a single page by id
     *
     * @param $id
     *
     * @return array|bool
     */
    public function getSinglePageById($id);

    /**
     * Get a single page by url
     *
     * @param $url
     *
     * @return array|bool
     */
    public function getSinglePageByUrl($url);

    /**
     * Get random pages
     *
     * @param integer $count
     *
     * @return array|bool
     */
    public function getRandomPages($count = 4);
}
