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
     * @return ViewModel
     */
    public function categoryAction()
    {
        $viewModel = new ViewModel();

        return $viewModel;
    }

    /**
     * @return ViewModel
     */
    public function pageAction()
    {
        $viewModel = new ViewModel();

        return $viewModel;
    }
}
