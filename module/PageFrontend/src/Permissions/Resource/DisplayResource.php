<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageFrontend\Permissions\Resource;

use Zend\Permissions\Acl\Resource\GenericResource;

/**
 * Class DisplayResource
 *
 * @package PageFrontend\Permissions\Resource
 */
class DisplayResource extends GenericResource
{
    /**
     * @const name of resource
     */
    const NAME = 'page-frontend-display';

    /**
     * @const names of privileges
     */
    const PRIVILEGE_CATEGORY = 'category';
    const PRIVILEGE_PAGE     = 'page';

    /**
     * DisplayResource constructor.
     */
    public function __construct()
    {
        parent::__construct(self::NAME);
    }
}
