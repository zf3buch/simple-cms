<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace UserModel\Entity;

use DateTime;

/**
 * Class UserEntity
 *
 * @package UserModel\Entity
 */
class UserEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var DateTime
     */
    private $registered;

    /**
     * @var DateTime
     */
    private $updated;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $role;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string|null
     */
    private $password;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (integer)$id;
    }

    /**
     * @return DateTime
     */
    public function getRegistered()
    {
        return $this->registered;
    }

    /**
     * @param DateTime $registered
     */
    public function setRegistered(DateTime $registered)
    {
        $this->registered = $registered;
    }

    /**
     * @return DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param DateTime $updated
     */
    public function setUpdated(DateTime $updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        if (!in_array($status, ['new', 'approved', 'blocked'])) {
            $status = 'new';
        }

        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        if (!in_array($role, ['editor', 'admin'])) {
            $role = 'editor';
        }

        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = trim($email);
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        if (empty($password)) {
            $password = null;
        }

        $this->password = $password;
    }

    /**
     * return void
     */
    public function encryptPassword()
    {
        if (!is_null($this->password)) {
            $this->password = password_hash(
                $this->password, PASSWORD_BCRYPT
            );
        }
    }

    /**
     * Update user
     */
    public function update()
    {
        $this->setUpdated(new DateTime());
    }

    /**
     * Approve user
     */
    public function approve()
    {
        $this->setStatus('approved');
        $this->setUpdated(new DateTime());
    }

    /**
     * Block user
     */
    public function block()
    {
        $this->setStatus('blocked');
        $this->setUpdated(new DateTime());
    }

}
