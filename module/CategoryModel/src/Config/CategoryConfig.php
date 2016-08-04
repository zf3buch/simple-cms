<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace CategoryModel\Config;

use Zend\Config\Config;

/**
 * Class CategoryConfig
 *
 * @package CategoryModel\Config
 */
class CategoryConfig extends Config implements CategoryConfigInterface
{
    /**
     * Get the status options
     */
    public function getStatusOptions()
    {
        return $this->get('status_options')->toArray();
    }
}
