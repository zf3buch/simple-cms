<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserModel\Permissions\Role;

use Zend\Permissions\Acl\Role\GenericRole;

/**
 * Class AdminRole
 *
 * @package UserModel\Permissions\Role
 */
class AdminRole extends GenericRole
{
    /**
     * @var string name of role
     */
    const NAME = 'admin';

    /**
     * AdminRole constructor.
     */
    public function __construct()
    {
        parent::__construct( self::NAME);
    }
}
