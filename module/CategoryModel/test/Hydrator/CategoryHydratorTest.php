<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryModelTest\Hydrator;

use CategoryModel\Hydrator\CategoryHydrator;
use PHPUnit_Framework_TestCase;

/**
 * Class CategoryHydratorTest
 *
 * @package CategoryModelTest\Hydrator
 */
class CategoryHydratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group category-model
     * @group model
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(CategoryHydrator::class));
    }
}
