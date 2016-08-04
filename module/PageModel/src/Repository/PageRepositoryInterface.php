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

use PageModel\Entity\PageEntity;
use Zend\Paginator\Paginator;

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
     * @return Paginator
     */
    public function getPagesByPage($page = 1, $count = 5);

    /**
     * Get all pages for a given category
     *
     * @param string $url
     * @param bool   $approved
     *
     * @return Paginator
     */
    public function getPagesByCategory($url, $approved = true);

    /**
     * Get a single page by id
     *
     * @param $id
     *
     * @return PageEntity|bool
     */
    public function getSinglePageById($id);

    /**
     * Get a single page by url
     *
     * @param $url
     *
     * @return PageEntity|bool
     */
    public function getSinglePageByUrl($url);

    /**
     * Get random pages
     *
     * @param integer $count
     *
     * @return Paginator
     */
    public function getRandomPages($count = 4);
}
