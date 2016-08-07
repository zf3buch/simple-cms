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

use Interop\Container\ContainerInterface;
use PageBackend\Controller\ModifyController;
use PageBackend\Controller\ModifyControllerFactory;
use PageBackend\Form\PageFormInterface;
use PageModel\Repository\PageRepositoryInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class ModifyControllerFactoryTest
 *
 * @package PageBackendTest\Controller
 */
class ModifyControllerFactoryTest extends PHPUnit_Framework_TestCase
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
        /** @var ContainerInterface $formElementManager */
        $formElementManager = $this->prophesize(ContainerInterface::class);

        /** @var PageFormInterface $pageForm */
        $pageForm = $this->prophesize(PageFormInterface::class);

        $formElementManager->get(PageFormInterface::class)
            ->willReturn($pageForm)
            ->shouldBeCalled();

        /** @var ContainerInterface $container */
        $container = $this->prophesize(ContainerInterface::class);

        /** @var PageRepositoryInterface $pageRepository */
        $pageRepository = $this->prophesize(
            PageRepositoryInterface::class
        );

        $container->get(PageRepositoryInterface::class)
            ->willReturn($pageRepository)
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
            $pageRepository->reveal(), 'pageRepository', $controller
        );

        $this->assertAttributeEquals(
            $pageForm->reveal(), 'pageForm', $controller
        );
    }
}
