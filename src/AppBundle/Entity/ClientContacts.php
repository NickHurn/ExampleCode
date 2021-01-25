<?php

// src/AppBundle/Entity/Users.php
namespace AppBundle\Entity;

use AppBundle\Form\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="client_contacts")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ClientContactsRespository")

 */
class ClientContacts
{

    public function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->active = true;
    }


    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false  )
     */
    private $dateCreated;
    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client", inversedBy="contacts")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;
    /**
     * @ORM\Column(name="firstname", type="string", length=64, nullable=false)
     */
    private $firstname;
    /**
     * @ORM\Column(name="surname", type="string", length=64, nullable=false)
     */
    private $surname;
    /**
     * @ORM\Column(name="job_title", type="string", length=255, nullable=true)
     */
    private $jobTitle ;
    /**
     * @ORM\Column(name="contact_no", type="string", length=64, nullable=true)
     */
    private $contactNo;
    /**
     * @ORM\Column(name="mobile_no", type="string", length=64, nullable=true)
     */
    private $mobileNo;
    /**
     * @ORM\Column(name="email", type="string", length=64, nullable=true)
     */
    private $email;
    /**
     * @ORM\Column(name="active", type="boolean", length=255)
     */
    private $active;
    /**
     * @ORM\Column(name="skype", type="string", length=255, nullable=true)
     */
    private $skype;
    /**
     * @ORM\Column(name="linkedin", type="string", length=255, nullable=true)
     */
    private $linkedin;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ClientContacts
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return ClientContacts
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateCreated
     * @return ClientContacts
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContactNo()
    {
        return $this->contactNo;
    }

    /**
     * @param mixed $contactNo
     * @return ClientContacts
     */
    public function setContactNo($contactNo)
    {
        $this->contactNo = $contactNo;
        return $this;
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
     * @return ClientContacts
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
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
     * @return ClientContacts
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
     * @return ClientContacts
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
     * @return ClientContacts
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }
    /**
     * @return mixed
     */
    public function _toArray()
    {
        $array=[
            'id'=>$this->getId(),
            'firstname'=>$this->getFirstname(),
            'surname'=>$this->getSurname(),
            'jobTitle'=>$this->getJobTitle(),
            'phone'=>$this->getContactNo(),
            'mobile'=>$this->getMobileNo(),
            'email'=>$this->getEmail(),
            'skype'=>$this->getSkype(),
            'linkedin'=>$this->getLinkedin(),
            'company'=>$this->getClient()->displayName(),
        ];
        return $array;
    }
    /**
     * @return mixed
     */
    public function getMobileNo()
    {
        return $this->mobileNo;
    }
    /**
     * @param mixed $mobileNo
     * @return ClientContacts
     */
    public function setMobileNo($mobileNo)
    {
        $this->mobileNo = $mobileNo;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * @param mixed $skype
     * @return ClientContacts
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * @param mixed $linkedin
     * @return ClientContacts
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * @param mixed $jobTitle
     * @return ClientContacts
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;
        return $this;
    }


}