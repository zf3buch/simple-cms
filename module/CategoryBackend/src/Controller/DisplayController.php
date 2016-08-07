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
 * Class DisplayController
 *
 * @package CategoryBackend\Controller
 */
class DisplayController extends AbstractActionController
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
     * Show category list
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        $page = $this->params()->fromRoute('page', 1);

        $categoryList = $this->categoryRepository->getCategoriesByPage(
            $page, 15
        );

        if (!$categoryList) {
            return $this->redirect()->toRoute(
                'category-backend', [], true
            );
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('categoryList', $categoryList);

        return $viewModel;
    }

    /**
     * Show category
     *
     * @return ViewModel
     */
    public function showAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute(
                'category-backend', [], true
            );
        }

        $category = $this->categoryRepository->getSingleCategoryById($id);

        if (!$category) {
            return $this->redirect()->toRoute(
                'category-backend', [], true
            );
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('category', $category);

        return $viewModel;
    }
}
