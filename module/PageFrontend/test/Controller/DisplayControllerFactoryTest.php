<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageFrontendTest\Controller;

use CategoryModel\Repository\CategoryRepositoryInterface;
use Interop\Container\ContainerInterface;
use PageFrontend\Controller\DisplayController;
use PageFrontend\Controller\DisplayControllerFactory;
use PageModel\Repository\PageRepositoryInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class DisplayControllerFactoryTest
 *
 * @package PageFrontendTest\Controller
 */
class DisplayControllerFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test factory
     *
     * @group controller
     * @group factory
     * @group page-frontend
     */
    public function testFactory()
    {
        /** @var PageRepositoryInterface $pageRepository */
        $pageRepository = $this->prophesize(
            PageRepositoryInterface::class
        );

        /** @var CategoryRepositoryInterface $categoryRepository */
        $categoryRepository = $this->prophesize(
            CategoryRepositoryInterface::class
        );

        /** @var ContainerInterface $container */
        $container = $this->prophesize(ContainerInterface::class);
        $container->get(PageRepositoryInterface::class)
            ->willReturn($pageRepository)
            ->shouldBeCalled();
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
            $pageRepository->reveal(), 'pageRepository', $controller
        );
    }
}
