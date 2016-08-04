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
use PageModel\Storage\PageStorageInterface;
use Zend\Paginator\Paginator;

/**
 * Class PageRepository
 *
 * @package PageModel\Repository
 */
class PageRepository implements PageRepositoryInterface
{
    /**
     * @var PageStorageInterface
     */
    private $pageStorage;

    /**
     * PageRepository constructor.
     *
     * @param PageStorageInterface $pageStorage
     */
    public function __construct(PageStorageInterface $pageStorage)
    {
        $this->pageStorage = $pageStorage;
    }

    /**
     * Get all pages for a given page
     *
     * @param int $page
     * @param int $count
     *
     * @return Paginator
     */
    public function getPagesByPage($page = 1, $count = 5)
    {
        return $this->pageStorage->fetchPageCollection($page, $count);
    }

    /**
     * Get all pages for a given category
     *
     * @param string $url
     * @param bool   $approved
     *
     * @return Paginator
     */
    public function getPagesByCategory($url, $approved = true)
    {
        return $this->pageStorage->fetchPageCollectionByCategory(
            $url, $approved
        );
    }

    /**
     * Get a single page by id
     *
     * @param $id
     *
     * @return PageEntity|bool
     */
    public function getSinglePageById($id)
    {
        return $this->pageStorage->fetchPageEntityById($id);
    }

    /**
     * Get a single page by url
     *
     * @param $url
     *
     * @return PageEntity|bool
     */
    public function getSinglePageByUrl($url)
    {
        return $this->pageStorage->fetchPageEntityByUrl($url);
    }

    /**
     * Get random pages
     *
     * @param integer $count
     *
     * @return Paginator
     */
    public function getRandomPages($count = 4)
    {
        return $this->pageStorage->fetchRandomPageCollection($count);
    }
}
