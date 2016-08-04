<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageBackend\Controller;

use PageModel\Repository\PageRepositoryInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class ModifyController
 *
 * @package PageBackend\Controller
 */
class ModifyController extends AbstractActionController
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
    public function addAction()
    {
        $viewModel = new ViewModel();

        return $viewModel;
    }

    /**
     * @return ViewModel
     */
    public function editAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute('page-backend', [], true);
        }

        $page = $this->pageRepository->getSinglePageById($id);

        if (!$page) {
            return $this->redirect()->toRoute('page-backend', [], true);
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('page', $page);

        return $viewModel;
    }

    /**
     * @return ViewModel
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute('page-backend', [], true);
        }

        $page = $this->pageRepository->getSinglePageById($id);

        if (!$page) {
            return $this->redirect()->toRoute('page-backend', [], true);
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('page', $page);

        return $viewModel;
    }

    /**
     * @return ViewModel
     */
    public function approveAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute('page-backend', [], true);
        }

        $page = $this->pageRepository->getSinglePageById($id);

        if (!$page) {
            return $this->redirect()->toRoute('page-backend', [], true);
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('page', $page);

        return $viewModel;
    }

    /**
     * @return ViewModel
     */
    public function blockAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute('page-backend', [], true);
        }

        $page = $this->pageRepository->getSinglePageById($id);

        if (!$page) {
            return $this->redirect()->toRoute('page-backend', [], true);
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('page', $page);

        return $viewModel;
    }
}
