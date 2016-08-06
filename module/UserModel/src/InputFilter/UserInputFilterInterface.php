<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserModel\InputFilter;

/**
 * Interface UserInputFilterInterface
 *
 * @package UserModel\InputFilter
 */
interface UserInputFilterInterface
{
    /**
     * @param array $statusOptions
     */
    public function setStatusOptions($statusOptions);

    /**
     * @param array $roleOptions
     */
    public function setRoleOptions($roleOptions);

    /**
     * Init input filter
     */
    public function init();
}
