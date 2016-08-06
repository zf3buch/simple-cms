<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace Application\Permissions\Resource;

use Zend\Permissions\Acl\Resource\GenericResource;

/**
 * Class IndexResource
 *
 * @package Application\Permissions\Resource
 */
class IndexResource extends GenericResource
{
    /**
     * @var string name of resource
     */
    const NAME = 'application-index';

    /**
     * @var string name of privileges
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
