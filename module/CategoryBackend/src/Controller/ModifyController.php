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
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class ModifyController
 *
 * @package CategoryBackend\Controller
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

        $viewModel = new ViewModel();
        $viewModel->setVariable('category', $category);

        return $viewModel;
    }
}
