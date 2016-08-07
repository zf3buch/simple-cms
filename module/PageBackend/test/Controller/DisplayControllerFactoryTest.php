<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageBackendTest\Controller;

use PageBackend\Controller\DisplayController;
use PageBackend\Controller\DisplayControllerFactory;
use PageModel\Repository\PageRepositoryInterface;
use Interop\Container\ContainerInterface;
use PHPUnit_Framework_TestCase;
use Prophecy\Prophecy\MethodProphecy;

/**
 * Class DisplayControllerFactoryTest
 *
 * @package PageBackendTest\Controller
 */
class DisplayControllerFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test factory
     *
     * @group controller
     * @group factory
     * @group page-backend
     */
    public function testFactory()
    {
        /** @var PageRepositoryInterface $pageRepository */
        $pageRepository = $this->prophesize(
            PageRepositoryInterface::class
        );

        /** @var ContainerInterface $container */
        $container = $this->prophesize(ContainerInterface::class);
        $container->get(PageRepositoryInterface::class)
            ->willReturn($pageRepository)
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
