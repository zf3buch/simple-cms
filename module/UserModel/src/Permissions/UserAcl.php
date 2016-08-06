<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserModel\Permissions;

use UserModel\Permissions\Role\AdminRole;
use UserModel\Permissions\Role\EditorRole;
use UserModel\Permissions\Role\GuestRole;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Acl as ZendAcl;

/**
 * Class UserAcl
 *
 * @package UserModel\Permissions
 */
class UserAcl extends ZendAcl
{
    /**
     * Acl constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->addRole(new GuestRole());
        $this->addRole(new EditorRole());
        $this->addRole(new AdminRole());

        $this->addConfig($config);
    }

    /**
     * @param array $config
     */
    private function addConfig(array $config)
    {
        foreach ($config as $roleName => $roleConfig) {
            foreach ($roleConfig as $resourceName => $resourceConfig) {
                if (!$this->hasResource($resourceName)) {
                    $this->addResource($resourceName);
                }

                foreach ($resourceConfig as $right => $privileges) {
                    switch ($right) {
                        case Acl::TYPE_ALLOW:
                            $this->allow(
                                $roleName, $resourceName, $privileges
                            );
                            break;

                        case Acl::TYPE_DENY:
                            $this->deny(
                                $roleName, $resourceName, $privileges
                            );
                            break;
                    }
                }
            }
        }
    }
}
