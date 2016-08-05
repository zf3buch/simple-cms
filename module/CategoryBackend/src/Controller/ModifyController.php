<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryBackend\Controller;

use CategoryBackend\Form\CategoryFormInterface;
use CategoryModel\Repository\CategoryRepositoryInterface;
use Zend\Form\Form;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\View\Model\ViewModel;

/**
 * Class ModifyController
 *
 * @package CategoryBackend\Controller
 * @method Request getRequest()
 * @method FlashMessenger flashMessenger()
 */
class ModifyController extends AbstractActionController
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var CategoryFormInterface|Form
     */
    private $categoryForm;

    /**
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function setCategoryRepository($categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param CategoryFormInterface $categoryForm
     */
    public function setCategoryForm($categoryForm)
    {
        $this->categoryForm = $categoryForm;
    }

    /**
     * Add new category
     *
     * @return ViewModel
     */
    public function addAction()
    {
        $this->categoryForm->addMode();

        if ($this->getRequest()->isPost()) {
            $this->categoryForm->setData($this->params()->fromPost());

            if ($this->categoryForm->isValid()) {
                $category = $this->categoryRepository->createCategoryFromData(
                    $this->categoryForm->getData()
                );

                $result = $this->categoryRepository->saveCategory($category);

                if ($result) {
                    $this->flashMessenger()->addSuccessMessage(
                        'Die neue Kategorie wurde gespeichert!'
                    );

                    return $this->redirect()->toRoute(
                        'category-backend/modify',
                        [
                            'action' => 'edit',
                            'id'     => $category->getId(),
                        ],
                        true
                    );
                }
            }

            $messages = $this->categoryForm->getMessages();

            if (isset($messages['csrf'])) {
                $this->flashMessenger()->addErrorMessage(
                    'Zeitüberschreitung! Bitte Formular erneut absenden!'
                );
            } else {
                $this->flashMessenger()->addErrorMessage(
                    'Bitte überprüfen Sie die Daten der Kategorie!'
                );
            }
        } else {
            $this->flashMessenger()->addInfoMessage(
                'Sie können die neue Kategorie nun anlegen!'
            );
        }

        $this->categoryForm->setAttribute(
            'action',
            $this->url()->fromRoute(
                'category-backend/modify', ['action' => 'add'], true
            )
        );
        $this->categoryForm->prepare();

        $viewModel = new ViewModel();
        $viewModel->setVariable('categoryForm', $this->categoryForm);

        return $viewModel;
    }

    /**
     * Edit exiting category
     *
     * @return ViewModel
     */
    public function editAction()
    {
        $this->categoryForm->editMode();

        $id = $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute('category-backend', [], true);
        }

        $category = $this->categoryRepository->getSingleCategoryById($id);

        if (!$category) {
            return $this->redirect()->toRoute('category-backend', [], true);
        }

        $this->categoryForm->bind($category);

        if ($this->getRequest()->isPost()) {
            $postData  = $this->params()->fromPost();
            $filesData = $this->params()->fromFiles();

            if (isset($filesData['image'])
                && $filesData['image']['size'] > 0
            ) {
                $postData = array_merge_recursive($postData, $filesData);
            }

            $this->categoryForm->setData($postData);
            $this->categoryForm->addImageFileUploadFilter();

            if ($this->categoryForm->isValid()) {
                $category->update();

                $result = $this->categoryRepository->saveCategory($category);

                if ($result) {
                    $this->flashMessenger()->addSuccessMessage(
                        'Die Kategorie wurde gespeichert!'
                    );

                    return $this->redirect()->toRoute(
                        'category-backend/modify',
                        [
                            'action' => 'edit',
                            'id'     => $category->getId(),
                        ],
                        true
                    );
                }
            }

            $messages = $this->categoryForm->getMessages();

            if (isset($messages['csrf'])) {
                $this->flashMessenger()->addErrorMessage(
                    'Zeitüberschreitung! Bitte Formular erneut absenden!'
                );
            } else {
                $this->flashMessenger()->addErrorMessage(
                    'Bitte überprüfen Sie die Daten der Kategorie!'
                );
            }
        } else {
            $this->flashMessenger()->addInfoMessage(
                'Sie können die Kategorie nun bearbeiten!'
            );
        }

        $this->categoryForm->setAttribute(
            'action',
            $this->url()->fromRoute(
                'category-backend/modify',
                ['action' => 'edit', 'id' => $id],
                true
            )
        );
        $this->categoryForm->prepare();

        $viewModel = new ViewModel();
        $viewModel->setVariable('category', $category);
        $viewModel->setVariable('categoryForm', $this->categoryForm);

        return $viewModel;
    }

    /**
     * Delete existing category
     *
     * @return ViewModel
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute('category-backend', [], true);
        }

        $category = $this->categoryRepository->getSingleCategoryById($id);

        if (!$category) {
            return $this->redirect()->toRoute('category-backend', [], true);
        }

        $delete = $this->params()->fromQuery('delete', 'no');

        if ($delete == 'yes') {
            $this->categoryRepository->deleteCategory($category);

            $this->flashMessenger()->addSuccessMessage(
                'Die Kategorie wurde gelöscht!'
            );

            return $this->redirect()->toRoute('category-backend', [], true);
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('category', $category);

        return $viewModel;
    }

    /**
     * Approve existing category
     *
     * @return ViewModel
     */
    public function approveAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute('category-backend', [], true);
        }

        $category = $this->categoryRepository->getSingleCategoryById($id);

        if (!$category) {
            return $this->redirect()->toRoute('category-backend', [], true);
        }

        $approve = $this->params()->fromQuery('approve', 'no');

        if ($approve == 'yes') {
            $category->approve();

            $this->categoryRepository->saveCategory($category);

            $this->flashMessenger()->addSuccessMessage(
                'Die Kategorie wurde genehmigt!'
            );

            return $this->redirect()->toRoute(
                'category-backend/show', ['id' => $category->getId()], true
            );
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('category', $category);

        return $viewModel;
    }

    /**
     * block exiting category
     *
     * @return ViewModel
     */
    public function blockAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute('category-backend', [], true);
        }

        $category = $this->categoryRepository->getSingleCategoryById($id);

        if (!$category) {
            return $this->redirect()->toRoute('category-backend', [], true);
        }

        $block = $this->params()->fromQuery('block', 'no');

        if ($block == 'yes') {
            $category->block();

            $this->categoryRepository->saveCategory($category);

            $this->flashMessenger()->addSuccessMessage(
                'Die Kategorie wurde gesperrt!'
            );

            return $this->redirect()->toRoute(
                'category-backend/show', ['id' => $category->getId()], true
            );
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('category', $category);

        return $viewModel;
    }
}
