<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageModel\Storage;

use PageModel\Entity\PageEntity;
use Zend\Paginator\Paginator;

/**
 * Interface PageStorageInterface
 *
 * @package PageModel\Storage
 */
interface PageStorageInterface
{
    /**
     * Fetch an page collection from storage
     *
     * @param int $page
     * @param int $count
     *
     * @return Paginator
     */
    public function fetchPageCollection($page = 1, $count = 5);

    /**
     * Fetch an page collection by type from storage
     *
     * @param string $url
     * @param bool   $approved
     *
     * @return Paginator
     */
    public function fetchPageCollectionByCategory($url, $approved = true);

    /**
     * Fetch random pages
     *
     * @param int $count
     *
     * @return Paginator
     */
    public function fetchRandomPageCollection($count = 4);

    /**
     * Fetch an page entity by id from storage
     *
     * @param int $id
     *
     * @return PageEntity
     */
    public function fetchPageEntityById($id);

    /**
     * Fetch an page entity by url from storage
     *
     * @param string $url
     *
     * @return PageEntity
     */
    public function fetchPageEntityByUrl($url);

    /**
     * Insert new page entity to storage
     *
     * @param PageEntity $page
     *
     * @return mixed
     */
    public function insertPage(PageEntity $page);

    /**
     * Update existing page entity in storage
     *
     * @param PageEntity $page
     *
     * @return mixed
     */
    public function updatePage(PageEntity $page);

    /**
     * Delete existing page entity from storage
     *
     * @param PageEntity $page
     *
     * @return mixed
     */
    public function deletePage(PageEntity $page);
}
