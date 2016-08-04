<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace Application\Controller;

use PageModel\Entity\PageEntity;
use PageModel\Hydrator\PageHydrator;
use PageModel\Storage\Db\PageDbStorage;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Test controller
 *
 * Handles the homepage and other pages
 *
 * @package    Application
 */
class TestController extends AbstractActionController
{
    /**
     * @var PageDbStorage
     */
    private $pageDbStorage;

    /**
     * @param PageDbStorage $pageDbStorage
     */
    public function setPageDbStorage($pageDbStorage)
    {
        $this->pageDbStorage = $pageDbStorage;
    }

    /**
     * Handle homepage
     */
    public function indexAction()
    {
        $pageEntity = $this->pageDbStorage->fetchPageEntityById(1);

        var_dump($pageEntity);

        $pageCollection = $this->pageDbStorage->fetchPageCollection(1, 5);

        var_dump($pageCollection->getCurrentItems());

        $pageData = [
            'id'                   => '123',
            'created'              => date('Y-m-d H:i:s'),
            'updated'              => date('Y-m-d H:i:s'),
            'status'               => 'approved',
            'category'             => '11',
            'title'                => 'Title',
            'url'                  => 'Url',
            'text'                 => 'Text',
            'author'               => 'Author',
            'category_id'          => '11',
            'category_updated'     => date('Y-m-d H:i:s'),
            'category_status'      => 'approved',
            'category_name'        => 'Name',
            'category_url'         => 'Url',
            'category_description' => 'Description',
            'category_image'       => 'Image',
        ];

        $pageEntity = new PageEntity();

        $pageHydrator = new PageHydrator();
        $pageHydrator->hydrate($pageData, $pageEntity);

        $result = $this->pageDbStorage->insertPage($pageEntity);

        var_dump($result);

        $pageEntity = $this->pageDbStorage->fetchPageEntityById(123);

        var_dump($pageEntity);

        $pageEntity->setAuthor('AUTHOR');

        $result = $this->pageDbStorage->updatePage($pageEntity);

        var_dump($result);

        $pageEntity = $this->pageDbStorage->fetchPageEntityById(123);

        var_dump($pageEntity);

        $result = $this->pageDbStorage->deletePage($pageEntity);

        var_dump($result);

        $pageEntity = $this->pageDbStorage->fetchPageEntityById(123);

        var_dump($pageEntity);

        exit;
    }
}
