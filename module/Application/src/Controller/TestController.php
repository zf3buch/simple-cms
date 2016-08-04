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
use DateTime;
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
        $categoryData = [
            'id'          => '123',
            'updated'     => new DateTime(),
            'status'      => 'approved',
            'name'        => 'Name',
            'url'         => 'Url',
            'description' => 'Description',
            'image'       => 'Image',
        ];

        $categoryEntity = new CategoryEntity();

        $categoryHydrator = new CategoryHydrator();
        $categoryHydrator->hydrate($categoryData, $categoryEntity);

        $pageData = [
            'id'       => '123',
            'created'  => new DateTime(),
            'updated'  => new DateTime(),
            'status'   => 'approved',
            'category' => $categoryEntity,
            'title'    => 'Title',
            'url'      => 'Url',
            'text'     => 'Text',
            'author'   => 'Author',
        ];

        $pageEntity = new PageEntity();

        $pageHydrator = new PageHydrator();
        $pageHydrator->hydrate($pageData, $pageEntity);

        var_dump($categoryEntity);
        var_dump($pageEntity);

        var_dump($categoryHydrator->extract($categoryEntity));
        var_dump($pageHydrator->extract($pageEntity));
        exit;
    }
}
