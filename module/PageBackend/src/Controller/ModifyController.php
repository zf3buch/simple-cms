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

use PageBackend\Form\PageFormInterface;
use PageModel\Repository\PageRepositoryInterface;
use Zend\Form\Form;
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
     * @var PageFormInterface|Form
     */
    private $pageForm;

    /**
     * @param PageRepositoryInterface $pageRepository
     */
    public function setPageRepository($pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @param PageFormInterface $pageForm
     */
    public function setPageForm($pageForm)
    {
        $this->pageForm = $pageForm;
    }

    /**
     * @return ViewModel
     */
    public function addAction()
    {
        $this->pageForm->setAttribute(
            'action',
            $this->url()->fromRoute(
                'page-backend/modify', ['action' => 'add'], true
            )
        );
        $this->pageForm->prepare();

        $viewModel = new ViewModel();
        $viewModel->setVariable('pageForm', $this->pageForm);

        return $viewModel;
    }

    /**
     * @return ViewModel
     */
    public function editAction()
    {
        $this->pageForm->editMode();

        $id = $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute('page-backend', [], true);
        }

        $page = $this->pageRepository->getSinglePageById($id);

        if (!$page) {
            return $this->redirect()->toRoute('page-backend', [], true);
        }

        $this->pageForm->bind($page);
        $this->pageForm->setAttribute(
            'action',
            $this->url()->fromRoute(
                'page-backend/modify',
                ['action' => 'edit', 'id' => $id],
                true
            )
        );
        $this->pageForm->prepare();

        $viewModel = new ViewModel();
        $viewModel->setVariable('page', $page);
        $viewModel->setVariable('pageForm', $this->pageForm);

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
