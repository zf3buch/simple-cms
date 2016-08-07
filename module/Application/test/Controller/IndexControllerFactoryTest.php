<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace ApplicationTest\Controller;

use Application\Controller\IndexController;
use Application\Controller\IndexControllerFactory;
use Interop\Container\ContainerInterface;
use PageModel\Repository\PageRepositoryInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class IndexControllerFactoryTest
 *
 * @package ApplicationTest\Controller
 */
class IndexControllerFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test factory
     *
     * @group controller
     * @group factory
     * @group application
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

        $factory = new IndexControllerFactory();

        /** @var IndexController $controller */
        $controller = $factory(
            $container->reveal(), IndexController::class
        );

        $this->assertTrue($controller instanceof IndexController);

        $this->assertAttributeEquals(
            $pageRepository->reveal(), 'pageRepository', $controller
        );
    }
}
