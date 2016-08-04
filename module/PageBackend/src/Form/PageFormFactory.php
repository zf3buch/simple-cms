<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageBackend\Form;

use PageModel\Config\PageConfigInterface;
use PageModel\Hydrator\PageHydrator;
use PageModel\InputFilter\PageInputFilter;
use CategoryModel\Repository\CategoryRepositoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\HydratorPluginManager;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterPluginManager;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class PageFormFactory
 *
 * @package PageBackend\Form
 */
class PageFormFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null|null    $options
     *
     * @return mixed
     */
    public function __invoke(
        ContainerInterface $container, $requestedName,
        array $options = null
    ) {
        /** @var HydratorPluginManager $hydratorManager */
        $hydratorManager = $container->get('HydratorManager');

        /** @var InputFilterPluginManager $inputFilterManager */
        $inputFilterManager = $container->get('InputFilterManager');

        /** @var PageHydrator $pageHydrator */
        $pageHydrator = $hydratorManager->get(PageHydrator::class);

        /** @var InputFilterInterface $pageInputFilter */
        $pageInputFilter = $inputFilterManager->get(
            PageInputFilter::class
        );

        /** @var PageConfigInterface $pageConfig */
        $pageConfig = $container->get(PageConfigInterface::class);

        /** @var CategoryRepositoryInterface $categoryRepository */
        $categoryRepository = $container->get(
            CategoryRepositoryInterface::class
        );

        $form = new PageForm();
        $form->setHydrator($pageHydrator);
        $form->setInputFilter($pageInputFilter);
        $form->setStatusOptions($pageConfig->getStatusOptions());
        $form->setCategoryOptions($categoryRepository->getCategoryOptions());

        return $form;
    }
}
