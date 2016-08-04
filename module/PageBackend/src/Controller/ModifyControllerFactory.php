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

use PageBackend\Form\PageForm;
use PageBackend\Form\PageFormInterface;
use PageModel\Repository\PageRepositoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Form\FormElementManager\FormElementManagerV3Polyfill;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ModifyControllerFactory
 *
 * @package PageBackend\Controller
 */
class ModifyControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        /** @var FormElementManagerV3Polyfill $formElementManager */
        $formElementManager = $container->get('FormElementManager');

        $pageRepository = $container->get(
            PageRepositoryInterface::class
        );

        /** @var PageFormInterface $pageForm */
        $pageForm = $formElementManager->get(PageForm::class);
        
        $controller = new ModifyController();
        $controller->setPageRepository($pageRepository);
        $controller->setPageForm($pageForm);

        return $controller;
    }
}
