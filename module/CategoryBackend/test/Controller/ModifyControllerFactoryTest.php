<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryBackendTest\Controller;

use CategoryBackend\Controller\ModifyController;
use CategoryBackend\Controller\ModifyControllerFactory;
use CategoryBackend\Form\CategoryForm;
use CategoryBackend\Form\CategoryFormInterface;
use CategoryModel\Repository\CategoryRepositoryInterface;
use Interop\Container\ContainerInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class ModifyControllerFactoryTest
 *
 * @package CategoryBackendTest\Controller
 */
class ModifyControllerFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test factory
     *
     * @group controller
     * @group factory
     * @group category-backend
     */
    public function testFactory()
    {
        /** @var ContainerInterface $formElementManager */
        $formElementManager = $this->prophesize(ContainerInterface::class);

        /** @var CategoryForm $categoryForm */
        $categoryForm = $this->prophesize(CategoryFormInterface::class);

        $formElementManager->get(CategoryFormInterface::class)
            ->willReturn($categoryForm)
            ->shouldBeCalled();

        /** @var ContainerInterface $container */
        $container = $this->prophesize(ContainerInterface::class);

        /** @var CategoryRepositoryInterface $categoryRepository */
        $categoryRepository = $this->prophesize(
            CategoryRepositoryInterface::class
        );

        $container->get(CategoryRepositoryInterface::class)
            ->willReturn($categoryRepository)
            ->shouldBeCalled();

        $container->get('FormElementManager')
            ->willReturn($formElementManager)
            ->shouldBeCalled();

        $factory = new ModifyControllerFactory();

        /** @var ModifyController $controller */
        $controller = $factory(
            $container->reveal(), ModifyController::class
        );

        $this->assertTrue($controller instanceof ModifyController);

        $this->assertAttributeEquals(
            $categoryRepository->reveal(), 'categoryRepository', $controller
        );

        $this->assertAttributeEquals(
            $categoryForm->reveal(), 'categoryForm', $controller
        );
    }
}
