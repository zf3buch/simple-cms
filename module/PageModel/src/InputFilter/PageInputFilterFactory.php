<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageModel\InputFilter;

use PageModel\Config\PageConfigInterface;
use CategoryModel\Repository\CategoryRepositoryInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class PageInputFilterFactory
 *
 * @package PageModel\InputFilter
 */
class PageInputFilterFactory implements FactoryInterface
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
        /** @var PageConfigInterface $pageConfig */
        $pageConfig = $container->get(PageConfigInterface::class);

        /** @var CategoryRepositoryInterface $categoryRepository */
        $categoryRepository = $container->get(
            CategoryRepositoryInterface::class
        );

        $inputFilter = new PageInputFilter();
        $inputFilter->setStatusOptions(
            array_keys($pageConfig->getStatusOptions())
        );
        $inputFilter->setTypeOptions(
            array_keys($pageConfig->getTypeOptions())
        );
        $inputFilter->setCategoryOptions(
            array_keys($categoryRepository->getCategoryOptions())
        );

        return $inputFilter;
    }
}