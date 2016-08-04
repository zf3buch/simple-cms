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
use DateTime;
use PageModel\Entity\PageEntity;
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
        $categoryEntity = new CategoryEntity();
        $categoryEntity->setId('123');
        $categoryEntity->setUpdated(new DateTime());
        $categoryEntity->setStatus('approved');
        $categoryEntity->setName('Name');
        $categoryEntity->setUrl('url');
        $categoryEntity->setDescription('Description');
        $categoryEntity->setImage('Image');

        $pageEntity = new PageEntity();
        $pageEntity->setId('123');
        $pageEntity->setCreated(new DateTime());
        $pageEntity->setUpdated(new DateTime());
        $pageEntity->setStatus('approved');
        $pageEntity->setCategory($categoryEntity);
        $pageEntity->setTitle('Title');
        $pageEntity->setUrl('Url');
        $pageEntity->setText('Text');
        $pageEntity->setAuthor('Author');

        var_dump($categoryEntity);
        var_dump($pageEntity);
        exit;
    }
}
