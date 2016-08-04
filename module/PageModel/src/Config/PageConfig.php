<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageModel\Config;

use Zend\Config\Config;

/**
 * Class PageConfig
 *
 * @package PageModel\Config
 */
class PageConfig extends Config implements PageConfigInterface
{
    /**
     * Get the status options
     */
    public function getStatusOptions()
    {
        return $this->get('status_options')->toArray();
    }

    /**
     * Get the type options
     */
    public function getTypeOptions()
    {
        return $this->get('type_options')->toArray();
    }
}
