<?php

// src/AppBundle/Entity/Users.php
namespace AppBundle\Entity;

use AppBundle\Form\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="company_details")
 * @ORM\Entity()

 */
class CompanyDetails
{

    public function __construct()
    {

    }


    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(name="logo", type="string", length=164, nullable=false)
     */
    private $logo;
    /**
     * @ORM\Column(name="co_name", type="string", length=64, nullable=false)
     */
    private $coName;
    /**
     * @ORM\Column(name="add_line1", type="string", length=255, nullable=false)
     */
    private $addLine1  ;
    /**
     * @ORM\Column(name="add_line2", type="string", length=255, nullable=true)
     */
    private $addLine2  ;
    /**
     * @ORM\Column(name="add_line3", type="string", length=255, nullable=true)
     */
    private $addLine3  ;
    /**
     * @ORM\Column(name="add_town", type="string", length=255, nullable=false)
     */
    private $addTown  ;
    /**
     * @ORM\Column(name="add_county", type="string", length=255, nullable=true)
     */
    private $addCounty  ;
    /**
     * @ORM\Column(name="add_postcode", type="string", length=255, nullable=false)
     */
    private $addPostcode  ;
    /**
     * @ORM\Column(name="contact_no", type="string", length=64, nullable=true)
     */
    private $contactNo;

    /**
     * @ORM\Column(name="mobile_no", type="string", length=64, nullable=true)
     */
    private $mobileNo;

    /**
     * @ORM\Column(name="email", type="string", length=64, nullable=false)
     */
    private $email;
    /**
     * @ORM\Column(name="co_number", type="string", length=64, nullable=false)
     */
    private $coNumber;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return CompanyDetails
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     * @return CompanyDetails
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCoName()
    {
        return $this->coName;
    }

    /**
     * @param mixed $coName
     * @return CompanyDetails
     */
    public function setCoName($coName)
    {
        $this->coName = $coName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddLine1()
    {
        return $this->addLine1;
    }

    /**
     * @param mixed $addLine1
     * @return CompanyDetails
     */
    public function setAddLine1($addLine1)
    {
        $this->addLine1 = $addLine1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddLine2()
    {
        return $this->addLine2;
    }

    /**
     * @param mixed $addLine2
     * @return CompanyDetails
     */
    public function setAddLine2($addLine2)
    {
        $this->addLine2 = $addLine2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddLine3()
    {
        return $this->addLine3;
    }

    /**
     * @param mixed $addLine3
     * @return CompanyDetails
     */
    public function setAddLine3($addLine3)
    {
        $this->addLine3 = $addLine3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddTown()
    {
        return $this->addTown;
    }

    /**
     * @param mixed $addTown
     * @return CompanyDetails
     */
    public function setAddTown($addTown)
    {
        $this->addTown = $addTown;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddCounty()
    {
        return $this->addCounty;
    }

    /**
     * @param mixed $addCounty
     * @return CompanyDetails
     */
    public function setAddCounty($addCounty)
    {
        $this->addCounty = $addCounty;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddPostcode()
    {
        return $this->addPostcode;
    }

    /**
     * @param mixed $addPostcode
     * @return CompanyDetails
     */
    public function setAddPostcode($addPostcode)
    {
        $this->addPostcode = $addPostcode;
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
     * @return CompanyDetails
     */
    public function setContactNo($contactNo)
    {
        $this->contactNo = $contactNo;
        return $this;
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
     * @return CompanyDetails
     */
    public function setMobileNo($mobileNo)
    {
        $this->mobileNo = $mobileNo;
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
     * @return CompanyDetails
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCoNumber()
    {
        return $this->coNumber;
    }

    /**
     * @param mixed $coNumber
     * @return CompanyDetails
     */
    public function setCoNumber($coNumber)
    {
        $this->coNumber = $coNumber;
        return $this;
    }


}