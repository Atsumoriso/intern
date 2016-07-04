<?php

namespace entity;

use entity\common\EntityCommonModelAbstract;
use ormatsumoriso\components\EntityInterface;

/**
 * User Model
 * 
 * Class to work with table api_user
 *
 * @package Entity
 */
class User extends EntityCommonModelAbstract implements EntityInterface
{

    const STATUS_NON_ACTIVE = 0;
    const STATUS_ACTIVE     = 1;

    /**
     * Attributes from the table.
     * @var
     */
    protected $user_id;
    protected $firstname;
    protected $lastname;
    protected $email;
    protected $username;
    protected $api_key;
    protected $created;
    protected $modified;
    protected $lognum;
    protected $reload_acl_flag;
    protected $is_active;
    

    /**
     * @return mixed
     */
    public function getTableName()
    {
        return 'api_user';
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->api_key;
    }

    /**
     * @param mixed $api_key
     */
    public function setApiKey($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    /**
     * @return mixed
     */
    public function getLognum()
    {
        return $this->lognum;
    }

    /**
     * @param mixed $lognum
     */
    public function setLognum($lognum)
    {
        $this->lognum = $lognum;
    }

    /**
     * @return mixed
     */
    public function getReloadAclFlag()
    {
        return $this->reload_acl_flag;
    }

    /**
     * @param mixed $reload_acl_flag
     */
    public function setReloadAclFlag($reload_acl_flag)
    {
        $this->reload_acl_flag = $reload_acl_flag;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @param mixed $is_active
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
    }

}