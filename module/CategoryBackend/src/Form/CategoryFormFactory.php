<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

/**
 * ZF3 book Zend Framework Center Example Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/zendframework-center
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace CategoryBackend\Form;

use CategoryModel\Config\CategoryConfigInterface;
use CategoryModel\Hydrator\CategoryHydrator;
use CategoryModel\InputFilter\CategoryInputFilter;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\HydratorPluginManager;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterPluginManager;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class CategoryFormFactory
 *
 * @package CategoryBackend\Form
 */
class CategoryFormFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null|null    $options
     *
     * @return mixed
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        /** @var HydratorPluginManager $hydratorManager */
        $hydratorManager = $container->get('HydratorManager');

        /** @var InputFilterPluginManager $inputFilterManager */
        $inputFilterManager = $container->get('InputFilterManager');

        /** @var CategoryHydrator $categoryHydrator */
        $categoryHydrator = $hydratorManager->get(CategoryHydrator::class);

        /** @var InputFilterInterface $categoryInputFilter */
        $categoryInputFilter = $inputFilterManager->get(
            CategoryInputFilter::class
        );

        /** @var CategoryConfigInterface $categoryConfig */
        $categoryConfig = $container->get(CategoryConfigInterface::class);

        $form = new CategoryForm();
        $form->setHydrator($categoryHydrator);
        $form->setInputFilter($categoryInputFilter);
        $form->setStatusOptions($categoryConfig->getStatusOptions());

        return $form;
    }
}
