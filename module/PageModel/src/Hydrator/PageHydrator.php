<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageModel\Hydrator;

use CategoryModel\Hydrator\CategoryHydrator;
use CategoryModel\Hydrator\Strategy\CategoryEntityStrategy;
use Zend\Hydrator\ClassMethods;
use Zend\Hydrator\HydratorInterface;
use Zend\Hydrator\Strategy\DateTimeFormatterStrategy;

/**
 * Class PageHydrator
 *
 * @package PageModel\Hydrator
 */
class PageHydrator extends ClassMethods implements HydratorInterface
{
    /**
     * PageHydrator constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->addStrategy(
            'created',
            new DateTimeFormatterStrategy('Y-m-d H:i:s')
        );
        $this->addStrategy(
            'updated',
            new DateTimeFormatterStrategy('Y-m-d H:i:s')
        );
        $this->addStrategy(
            'category',
            new CategoryEntityStrategy(new CategoryHydrator())
        );
    }
}
