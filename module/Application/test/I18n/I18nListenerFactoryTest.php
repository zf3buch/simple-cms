<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace ApplicationTest\I18n;

use Application\I18n\I18nListener;
use Application\I18n\I18nListenerFactory;
use Interop\Container\ContainerInterface;
use PHPUnit_Framework_TestCase;
use Zend\I18n\Translator\TranslatorInterface;

/**
 * Class I18nListenerFactoryTest
 *
 * @package ApplicationTest\I18n
 */
class I18nListenerFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test factory
     *
     * @group listener
     * @group factory
     * @group application
     */
    public function testFactory()
    {
        $config = [
            'i18n' => [
                'defaultLang'    => 'de',
                'allowedLocales' => [
                    'de' => 'de_DE',
                    'en' => 'en_US',
                ],
            ],
        ];

        /** @var TranslatorInterface $translator */
        $translator = $this->prophesize(TranslatorInterface::class);

        /** @var ContainerInterface $container */
        $container = $this->prophesize(ContainerInterface::class);
        $container->get(TranslatorInterface::class)
            ->willReturn($translator)
            ->shouldBeCalled();
        $container->get('config')
            ->willReturn($config)
            ->shouldBeCalled();

        $factory = new I18nListenerFactory();

        /** @var I18nListener $table */
        $listener = $factory($container->reveal(), I18nListener::class);

        $this->assertTrue($listener instanceof I18nListener);

        $this->assertAttributeEquals(
            $translator->reveal(), 'translator', $listener
        );
        $this->assertAttributeEquals(
            $config['i18n']['defaultLang'], 'defaultLang', $listener
        );
        $this->assertAttributeEquals(
            $config['i18n']['allowedLocales'], 'allowedLocales', $listener
        );
    }
}
