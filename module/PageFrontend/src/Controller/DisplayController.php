<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageFrontend\Controller;

use PageModel\Repository\PageRepositoryInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class DisplayController
 *
 * @package PageFrontend\Controller
 */
class DisplayController extends AbstractActionController
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @param PageRepositoryInterface $pageRepository
     */
    public function setPageRepository($pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @return ViewModel
     */
    public function categoryAction()
    {
        $url = $this->params()->fromRoute('url');

        $pageList = $this->pageRepository->getPagesByCategory($url);

        if (!$pageList) {
            return $this->redirect()->toRoute('home', [], true);
        }

        var_dump($pageList);
        exit;
    }

    /**
     * @return ViewModel
     */
    public function pageAction()
    {
        $url = $this->params()->fromRoute('url');

        if (!$url) {
            return $this->redirect()->toRoute('home', [], true);
        }

        $page = $this->pageRepository->getSinglePageByUrl($url);

        if (!$page || $page['status'] != 'approved') {
            return $this->redirect()->toRoute('home', [], true);
        }

        var_dump($page);
        exit;
    }
}
