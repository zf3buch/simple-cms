<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageModel\InputFilter;

/**
 * Interface PageInputFilterInterface
 *
 * @package PageModel\InputFilter
 */
interface PageInputFilterInterface
{
    /**
     * @param array $statusOptions
     */
    public function setStatusOptions($statusOptions);

    /**
     * @param array $categoryOptions
     */
    public function setCategoryOptions($categoryOptions);

    /**
     * Init input filter
     */
    public function init();
}