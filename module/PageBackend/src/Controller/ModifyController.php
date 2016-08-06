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
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\View\Model\ViewModel;

/**
 * Class ModifyController
 *
 * @package PageBackend\Controller
 * @method Request getRequest()
 * @method FlashMessenger flashMessenger()
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
        if ($this->getRequest()->isPost()) {
            $this->pageForm->setData($this->params()->fromPost());

            if ($this->pageForm->isValid()) {
                $page = $this->pageRepository->createPageFromData(
                    $this->pageForm->getData()
                );

                $result = $this->pageRepository->savePage($page);

                if ($result) {
                    $this->flashMessenger()->addSuccessMessage(
                        'page_backend_message_saved_page'
                    );

                    return $this->redirect()->toRoute(
                        'page-backend/modify',
                        [
                            'action' => 'edit',
                            'id'     => $page->getId(),
                        ],
                        true
                    );
                }
            }

            $messages = $this->pageForm->getMessages();

            if (isset($messages['csrf'])) {
                $this->flashMessenger()->addErrorMessage(
                    'page_backend_message_form_timeout'
                );
            } else {
                $this->flashMessenger()->addErrorMessage(
                    'page_backend_message_check_data'
                );
            }
        } else {
            $this->flashMessenger()->addInfoMessage(
                'page_backend_message_create_page'
            );
        }

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

        if ($this->getRequest()->isPost()) {
            $this->pageForm->setData($this->params()->fromPost());

            if ($this->pageForm->isValid()) {
                $page->update();

                $result = $this->pageRepository->savePage($page);

                if ($result) {
                    $this->flashMessenger()->addSuccessMessage(
                        'page_backend_message_saved_page'
                    );

                    return $this->redirect()->toRoute(
                        'page-backend/modify',
                        [
                            'action' => 'edit',
                            'id'     => $page->getId(),
                        ],
                        true
                    );
                }
            }

            $messages = $this->pageForm->getMessages();

            if (isset($messages['csrf'])) {
                $this->flashMessenger()->addErrorMessage(
                    'page_backend_message_form_timeout'
                );
            } else {
                $this->flashMessenger()->addErrorMessage(
                    'page_backend_message_check_data'
                );
            }
        } else {
            $this->flashMessenger()->addInfoMessage(
                'page_backend_message_update_page'
            );
        }

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

        $delete = $this->params()->fromQuery('delete', 'no');

        if ($delete == 'yes') {
            $this->pageRepository->deletePage($page);

            $this->flashMessenger()->addSuccessMessage(
                'page_backend_message_deleted_page'
            );

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

        $approve = $this->params()->fromQuery('approve', 'no');

        if ($approve == 'yes') {
            $page->approve();

            $this->pageRepository->savePage($page);

            $this->flashMessenger()->addSuccessMessage(
                'page_backend_message_approved_page'
            );

            return $this->redirect()->toRoute(
                'page-backend/show', ['id' => $page->getId()], true
            );
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

        $block = $this->params()->fromQuery('block', 'no');

        if ($block == 'yes') {
            $page->block();

            $this->pageRepository->savePage($page);

            $this->flashMessenger()->addSuccessMessage(
                'page_backend_message_blocked_page'
            );

            return $this->redirect()->toRoute(
                'page-backend/show', ['id' => $page->getId()], true
            );
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('page', $page);

        return $viewModel;
    }
}
