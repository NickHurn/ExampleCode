<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="role")
 * @ORM\Entity()
 */
class Role
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name",type="string", length=25)
     */
    private $name;

    /**
     * @ORM\Column(name="friendly_name", type="string", length=25)
     */
    private $friendlyName;


    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", mappedBy="roles")
     */
    private $users;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Role
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     * @return Role
     */
    public function setUsers($users)
    {
        $this->users = $users;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFriendlyName()
    {
        return $this->friendlyName;
    }

    /**
     * @param mixed $friendlyName
     * @return Role
     */
    public function setFriendlyName($friendlyName)
    {
        $this->friendlyName = $friendlyName;
        return $this;
    }



}