<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryModel\Hydrator\Strategy;

use CategoryModel\Entity\CategoryEntity;
use Zend\Hydrator\HydratorInterface;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class CategoryEntityStrategy
 *
 * @package CategoryModel\Hydrator\Strategy
 */
class CategoryEntityStrategy implements StrategyInterface
{
    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * CategoryEntityStrategy constructor.
     *
     * @param HydratorInterface $hydrator
     */
    public function __construct(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @param integer|CategoryEntity $value
     *
     * @return mixed
     */
    public function extract($value)
    {
        if ($value instanceof CategoryEntity) {
            return $value->getId();
        }

        return $value;
    }

    /**
     * @param mixed $value
     * @param array $data
     *
     * @return mixed
     */
    public function hydrate($value, $data = [])
    {
        $categoryData = [];

        foreach ($data as $key => $value) {
            if (substr($key, 0, 9) != 'category_') {
                continue;
            }

            $categoryData[substr($key, 9)] = $value;
        }

        $categoryEntity = new CategoryEntity();

        $this->hydrator->hydrate($categoryData, $categoryEntity);

        return $categoryEntity;
    }
}
