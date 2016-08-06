<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserFrontend\Permissions\Resource;

use Zend\Permissions\Acl\Resource\GenericResource;

/**
 * Class IndexResource
 *
 * @package UserFrontend\Permissions\Resource
 */
class IndexResource extends GenericResource
{
    /**
     * @const name of resource
     */
    const NAME = 'user-frontend-index';

    /**
     * @const names of privileges
     */
    const PRIVILEGE_INDEX = 'index';

    /**
     * IndexResource constructor.
     */
    public function __construct()
    {
        parent::__construct(self::NAME);
    }
}
