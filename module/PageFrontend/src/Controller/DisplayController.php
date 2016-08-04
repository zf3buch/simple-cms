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

use CategoryModel\Repository\CategoryRepositoryInterface;
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
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @param PageRepositoryInterface $pageRepository
     */
    public function setPageRepository($pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function setCategoryRepository($categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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

        $category = $this->categoryRepository->getSingleCategoryById();

        $viewModel = new ViewModel();
        $viewModel->setVariable('pageList', $pageList);
        $viewModel->setVariable('category', $pageList->getItem()->getCategory());

        return $viewModel;
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

        if (!$page || $page->getStatus() != 'approved') {
            return $this->redirect()->toRoute('home', [], true);
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('page', $page);

        return $viewModel;
    }
}
