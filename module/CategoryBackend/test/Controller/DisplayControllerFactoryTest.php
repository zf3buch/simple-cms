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

use CategoryBackend\Controller\DisplayController;
use CategoryBackend\Controller\DisplayControllerFactory;
use CategoryModel\Repository\CategoryRepositoryInterface;
use Interop\Container\ContainerInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class DisplayControllerFactoryTest
 *
 * @package CategoryBackendTest\Controller
 */
class DisplayControllerFactoryTest extends PHPUnit_Framework_TestCase
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
        /** @var CategoryRepositoryInterface $categoryRepository */
        $categoryRepository = $this->prophesize(
            CategoryRepositoryInterface::class
        );

        /** @var ContainerInterface $container */
        $container = $this->prophesize(ContainerInterface::class);
        $container->get(CategoryRepositoryInterface::class)
            ->willReturn($categoryRepository)
            ->shouldBeCalled();

        $factory = new DisplayControllerFactory();

        /** @var DisplayController $controller */
        $controller = $factory(
            $container->reveal(), DisplayController::class
        );

        $this->assertTrue($controller instanceof DisplayController);

        $this->assertAttributeEquals(
            $categoryRepository->reveal(), 'categoryRepository', $controller
        );
    }
}
