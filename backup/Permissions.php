<?php

namespace Derby\AccessControl;

class Permissions
{

    const PERMISSION_NONE = 0;
    const PERMISSION_EXECUTE = 1;
    const PERMISSION_WRITE = 2;
    const PERMISSION_WRITE_EXECUTE = 3;
    const PERMISSION_READ = 4;
    const PERMISSION_READ_EXECUTE = 5;
    const PERMISSION_READ_WRITE = 6;
    const PERMISSION_ALL = 7;

    /**
     * @var string
     */
    protected $owner;

    /**
     * @var string
     */
    protected $group;

    /**
     * @var int
     */
    protected $ownerPermissions;

    /**
     * @var int
     */
    protected $groupPermissions;

    /**
     * @var int
     */
    protected $anonPermissions;

    /**
     * @param $owner
     * @param $group
     * @param int $ownerPermissions
     * @param int $groupPermissions
     * @param int $anonPermissions
     */
    public function __construct($owner, $group, $ownerPermissions = 0, $groupPermissions = 0, $anonPermissions = 0)
    {
        $this->owner            = $owner;
        $this->group            = $group;
        $this->ownerPermissions = $ownerPermissions;
        $this->groupPermissions = $groupPermissions;
        $this->anonPermissions  = $anonPermissions;
    }

    /**************************************
     * Owner / GROUP SETTERS/GETTERS
     **************************************/

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     * @return $this
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param string $group
     * @return $this
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**************************************
     * PERMISSIONS SETTERS/GETTERS
     **************************************/

    /**
     * @param $ownerPermissions
     */
    public function setOwnerPermissions($ownerPermissions)
    {
        $this->ownerPermissions = $ownerPermissions;
    }

    /**
     * @return int
     */
    public function getOwnerPermissions()
    {
        return $this->ownerPermissions;
    }

    /**
     * @param $groupPermissions
     */
    public function setGroupPermissions($groupPermissions)
    {
        $this->groupPermissions = $groupPermissions;
    }

    /**
     * @return int
     */
    public function getGroupPermissions()
    {
        return $this->groupPermissions;
    }

    /**
     * @param $anonPermissions
     */
    public function setAnonymousPermissions($anonPermissions)
    {
        $this->anonPermissions = $anonPermissions;
    }

    /**
     * @return int
     */
    public function getAnonymousPermissions()
    {
        return $this->anonPermissions;
    }

    /**************************************
     * PERMISSIONS CHECKERS
     **************************************/

    /**
     * @return bool
     */
    public function canOwnerRead()
    {
        return (bool)($this->ownerPermissions & self::PERMISSION_READ);
    }

    /**
     * @return bool
     */
    public function canOwnerWrite()
    {
        return (bool)($this->ownerPermissions & self::PERMISSION_WRITE);
    }

    /**
     * @return bool
     */
    public function canOwnerExecute()
    {
        return (bool)($this->ownerPermissions & self::PERMISSION_EXECUTE);
    }

    /**
     * @return bool
     */
    public function canGroupRead()
    {
        return (bool)($this->groupPermissions & self::PERMISSION_READ);
    }

    /**
     * @return bool
     */
    public function canGroupWrite()
    {
        return (bool)($this->groupPermissions & self::PERMISSION_WRITE);
    }

    /**
     * @return bool
     */
    public function canGroupExecute()
    {
        return (bool)($this->groupPermissions & self::PERMISSION_EXECUTE);
    }

    /**
     * @return bool
     */
    public function canAnonRead()
    {
        return (bool)($this->anonPermissions & self::PERMISSION_READ);
    }

    /**
     * @return bool
     */
    public function canAnonWrite()
    {
        return (bool)($this->anonPermissions & self::PERMISSION_WRITE);
    }

    /**
     * @return bool
     */
    public function canAnonExecute()
    {
        return (bool)($this->anonPermissions & self::PERMISSION_EXECUTE);
    }


    /**************************************
     * OWNER PERMISSIONS
     **************************************/

    /**
     * @return $this
     */
    public function allowOwnerRead()
    {
        $this->ownerPermissions |= self::PERMISSION_READ;

        return $this;
    }

    /**
     * @return $this
     */
    public function denyOwnerRead()
    {
        $this->ownerPermissions &= ~self::PERMISSION_READ;

        return $this;
    }

    /**
     * @return $this
     */
    public function allowOwnerWrite()
    {
        $this->ownerPermissions |= self::PERMISSION_WRITE;

        return $this;
    }

    /**
     * @return $this
     */
    public function denyOwnerWrite()
    {
        $this->ownerPermissions &= ~self::PERMISSION_WRITE;

        return $this;
    }

    /**
     * @return $this
     */
    public function allowOwnerExecute()
    {
        $this->ownerPermissions |= self::PERMISSION_EXECUTE;

        return $this;
    }

    /**
     * @return $this
     */
    public function denyOwnerExecute()
    {
        $this->ownerPermissions &= ~self::PERMISSION_EXECUTE;

        return $this;
    }

    /**
     * @return $this
     */
    public function allowOwnerAll()
    {
        $this->ownerPermissions = self::PERMISSION_ALL;

        return $this;
    }

    /**
     * @return $this
     */
    public function denyOwnerAll()
    {
        $this->ownerPermissions = self::PERMISSION_NONE;

        return $this;

    }

    /**************************************
     * GROUP PERMISSIONS
     **************************************/

    /**
     * @return $this
     */
    public function allowGroupRead()
    {
        $this->groupPermissions |= self::PERMISSION_READ;

        return $this;
    }

    /**
     * @return $this
     */
    public function denyGroupRead()
    {
        $this->groupPermissions &= ~self::PERMISSION_READ;

        return $this;
    }

    /**
     * @return $this
     */
    public function allowGroupWrite()
    {
        $this->groupPermissions |= self::PERMISSION_WRITE;

        return $this;
    }

    /**
     * @return $this
     */
    public function denyGroupWrite()
    {
        $this->groupPermissions &= ~self::PERMISSION_WRITE;

        return $this;
    }

    /**
     * @return $this
     */
    public function allowGroupExecute()
    {
        $this->groupPermissions |= self::PERMISSION_EXECUTE;

        return $this;
    }

    /**
     * @return $this
     */
    public function denyGroupExecute()
    {
        $this->groupPermissions &= ~self::PERMISSION_EXECUTE;

        return $this;
    }

    /**
     * @return $this
     */
    public function allowGroupAll()
    {
        $this->groupPermissions = self::PERMISSION_ALL;

        return $this;
    }

    /**
     * @return $this
     */
    public function denyGroupAll()
    {
        $this->groupPermissions = self::PERMISSION_NONE;

        return $this;
    }


    /**************************************
     * ANON PERMISSIONS
     **************************************/

    /**
     * @return $this
     */
    public function allowAnonRead()
    {
        $this->anonPermissions |= self::PERMISSION_READ;

        return $this;
    }

    /**
     * @return $this
     */
    public function denyAnonRead()
    {
        $this->anonPermissions &= ~self::PERMISSION_READ;

        return $this;
    }

    /**
     * @return $this
     */
    public function allowAnonWrite()
    {
        $this->anonPermissions |= self::PERMISSION_WRITE;

        return $this;
    }

    /**
     * @return $this
     */
    public function denyAnonWrite()
    {
        $this->anonPermissions &= ~self::PERMISSION_WRITE;

        return $this;
    }

    /**
     * @return $this
     */
    public function allowAnonExecute()
    {
        $this->anonPermissions |= self::PERMISSION_EXECUTE;

        return $this;
    }

    /**
     * @return $this
     */
    public function denyAnonExecute()
    {
        $this->anonPermissions &= ~self::PERMISSION_EXECUTE;

        return $this;
    }

    /**
     * @return $this
     */
    public function allowAnonAll()
    {
        $this->anonPermissions = self::PERMISSION_ALL;

        return $this;
    }

    /**
     * @return $this
     */
    public function denyAnonAll()
    {
        $this->anonPermissions = self::PERMISSION_NONE;

        return $this;
    }
}
