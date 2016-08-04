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

use CategoryModel\Entity\CategoryEntity;
use CategoryModel\Hydrator\CategoryHydrator;
use PageModel\Entity\PageEntity;
use PageModel\Hydrator\PageHydrator;
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
     * Handle homepage
     */
    public function indexAction()
    {
        $pageData = [
            'id'                   => '123',
            'created'              => date('Y-m-d H:i:s'),
            'updated'              => date('Y-m-d H:i:s'),
            'status'               => 'approved',
            'category'             => '123',
            'title'                => 'Title',
            'url'                  => 'Url',
            'text'                 => 'Text',
            'author'               => 'Author',
            'category_id'          => '123',
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

        var_dump($pageEntity);
        var_dump($pageHydrator->extract($pageEntity));
        exit;
    }
}
