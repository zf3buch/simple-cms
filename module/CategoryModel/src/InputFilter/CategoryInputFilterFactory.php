<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryModel\InputFilter;

use CategoryModel\Config\CategoryConfigInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class CategoryInputFilterFactory
 *
 * @package CategoryModel\InputFilter
 */
class CategoryInputFilterFactory implements FactoryInterface
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
        /** @var CategoryConfigInterface $categoryConfig */
        $categoryConfig = $container->get(CategoryConfigInterface::class);

        $inputFilter = new CategoryInputFilter();
        $inputFilter->setStatusOptions(
            array_keys($categoryConfig->getStatusOptions())
        );

        return $inputFilter;
    }
}