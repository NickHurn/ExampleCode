<?php
/**
 * Created by PhpStorm.
 * User: hades
 * Date: 14/07/2020
 * Time: 22:56
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\FormTypeInterface;


/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")

 */
class User implements UserInterface, \Serializable
{
    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->dateAdded = new \DateTime();
        $this->active = true;
        $this->tempPassword = true;
    }
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="guid", type="string", length=255, unique=true)
     */
    private $guid;

    /**
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @ORM\ManyToMany (targetEntity="AppBundle\Entity\Role", inversedBy="users")
     * @ORM\JoinTable(name="users_roles")
     */
    private $roles;
    /**
     * @ORM\Column(name="firstname", type="string", length=64)
     */
    private $firstname;
    /**
     * @ORM\Column(name="surname", type="string", length=64)
     */
    private $surname;
    /**
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;
    /**
     * @ORM\Column(name="date_added", type="datetime",)
     */
    private $dateAdded  ;
    /**
     * @ORM\Column(name="temp_password", type="boolean")
     */
    private $tempPassword;
    /**
     * One user has One client.
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;


    /**
     * @return mixed
     */
    public function getRoles()
    {

        foreach($this->roles as $r){
            $arole[] = $r->getName();
        }
        return $arole;
    }
    /**
     * @param mixed $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles->add($roles);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
    /**
     * @return mixed
     */

    public function eraseCredentials()
    {
    }
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
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
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @param mixed $dateAdded
     * @return User
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempPassword()
    {
        return $this->tempPassword;
    }

    /**
     * @param mixed $tempPassword
     * @return User
     */
    public function setTempPassword($tempPassword)
    {
        $this->tempPassword = $tempPassword;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * @param mixed $guid
     * @return User
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     * @return User
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }



}