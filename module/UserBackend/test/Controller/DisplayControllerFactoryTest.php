<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserBackendTest\Controller;

use UserBackend\Controller\DisplayController;
use UserBackend\Controller\DisplayControllerFactory;
use UserModel\Repository\UserRepositoryInterface;
use Interop\Container\ContainerInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class DisplayControllerFactoryTest
 *
 * @package UserBackendTest\Controller
 */
class DisplayControllerFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test factory
     *
     * @group controller
     * @group factory
     * @group user-backend
     */
    public function testFactory()
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->prophesize(
            UserRepositoryInterface::class
        );

        /** @var ContainerInterface $container */
        $container = $this->prophesize(ContainerInterface::class);
        $container->get(UserRepositoryInterface::class)
            ->willReturn($userRepository)
            ->shouldBeCalled();

        $factory = new DisplayControllerFactory();

        /** @var DisplayController $controller */
        $controller = $factory(
            $container->reveal(), DisplayController::class
        );

        $this->assertTrue($controller instanceof DisplayController);

        $this->assertAttributeEquals(
            $userRepository->reveal(), 'userRepository', $controller
        );
    }
}
