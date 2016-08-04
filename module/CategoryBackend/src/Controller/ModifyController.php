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

use CategoryModel\Repository\CategoryRepositoryInterface;
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
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function setCategoryRepository($categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Add new category
     *
     * @return ViewModel
     */
    public function addAction()
    {
        $viewModel = new ViewModel();

        return $viewModel;
    }

    /**
     * Edit exiting category
     *
     * @return ViewModel
     */
    public function editAction()
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
