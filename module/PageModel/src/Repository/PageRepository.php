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

use CategoryModel\Entity\CategoryEntity;
use DateTime;
use PageModel\Entity\PageEntity;
use PageModel\Storage\PageStorageInterface;
use TravelloFilter\Filter\StringToUrlSlug;
use Zend\Filter\StaticFilter;
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

    /**
     * Create a new page based on array data
     *
     * @param array $data
     *
     * @return PageEntity
     */
    public function createPageFromData(array $data = [])
    {
        $category = new CategoryEntity();
        $category->setId($data['category']);

        $nextId = $this->pageStorage->nextId();

        $url = StaticFilter::execute(
            $data['title'], StringToUrlSlug::class
        );

        $page = new PageEntity();
        $page->setId($nextId);
        $page->setCreated(new DateTime());
        $page->setUpdated(new DateTime());
        $page->setStatus($data['status']);
        $page->setCategory($category);
        $page->setTitle($data['title']);
        $page->setUrl($url);
        $page->setText($data['text']);
        $page->setAuthor($data['author']);

        return $page;
    }

    /**
     * Save page
     *
     * @param PageEntity $page
     *
     * @return boolean
     */
    public function savePage(PageEntity $page)
    {
        if (!$page->getId()) {
            return $this->pageStorage->insertPage($page);
        } else {
            return $this->pageStorage->updatePage($page);
        }
    }

    /**
     * Delete an page
     *
     * @param PageEntity $page
     *
     * @return boolean
     */
    public function deletePage(PageEntity $page)
    {
        return $this->pageStorage->deletePage($page);
    }
}
