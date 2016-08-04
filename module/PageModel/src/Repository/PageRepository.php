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

use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;

/**
 * Class PageRepository
 *
 * @package PageModel\Repository
 */
class PageRepository implements PageRepositoryInterface
{
    /**
     * @var array
     */
    private $pageData = [];

    /**
     * @var array
     */
    private $categoryData = [];

    /**
     * PageRepository constructor.
     *
     * @param array $pageData
     * @param array $categoryData
     */
    public function __construct(array $pageData, array $categoryData)
    {
        $this->pageData     = $pageData;
        $this->categoryData = $categoryData;
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
        $pageList = $this->pageData;

        $paginator = new Paginator(
            new ArrayAdapter($pageList)
        );
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($count);

        /** @var \ArrayIterator $currentItemsIterator */
        $currentItemsIterator = $paginator->getCurrentItems();

        foreach ($currentItemsIterator as $key => $page) {
            $category = $this->categoryData[$page['category']];
            $page['category'] = $category;

            $currentItemsIterator->offsetSet($key, $page);
        }

        return $paginator;
    }

    /**
     * Get all pages for a given category
     *
     * @param string $url
     * @param bool   $approved
     *
     * @return mixed
     */
    public function getPagesByCategory($url, $approved = true)
    {
        $pageList = [];

        foreach ($this->pageData as $key => $page) {
            $category = $this->getCategoryByUrl($url);

            if ($page['category'] != $category['id']) {
                continue;
            }

            if ($approved && $page['status'] != 'approved') {
                continue;
            }

            $pageList[$key] = $page;

            $pageList[$key]['category'] = $category;
        }

        return $pageList;
    }

    /**
     * Get a single page by id
     *
     * @param $id
     *
     * @return array|bool
     */
    public function getSinglePageById($id)
    {
        if (!isset($this->pageData[$id])) {
            return false;
        }

        $page     = $this->pageData[$id];
        $category = $this->categoryData[$page['category']];

        $page['category'] = $category;

        return $page;
    }

    /**
     * Get a single page by url
     *
     * @param $url
     *
     * @return array|bool
     */
    public function getSinglePageByUrl($url)
    {
        foreach ($this->pageData as $page) {
            if ($page['url'] == $url) {
                return $this->getSinglePageById($page['id']);
            }
        }

        return false;
    }

    /**
     * Get random pages
     *
     * @param integer $count
     *
     * @return array|bool
     */
    public function getRandomPages($count = 4)
    {
        $pageList = [];

        foreach (array_rand($this->pageData, $count) as $id) {
            $pageList[$id] = $this->getSinglePageById($id);
        }

        return $pageList;
    }

    /**
     * Get category by url
     *
     * @param $url
     *
     * @return bool|array
     */
    private function getCategoryByUrl($url)
    {
        foreach ($this->categoryData as $category) {
            if ($category['url'] == $url) {
                return $category;
            }
        }

        return false;
    }
}
