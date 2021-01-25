<?php

// src/AppBundle/Entity/Users.php
namespace AppBundle\Entity;

use AppBundle\Form\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="invoice_settings")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\InvoiceSettingsRepository")

 */
class InvoiceSettings
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
     * @ORM\Column(name="payment_terms", type="integer", nullable=false)
     */
    private $paymentTerms;

    /**
     * @ORM\Column(name="invoice_logo", type="string", length=64, nullable=false)
     */
    private $invoiceLogo;
    /**
     * @ORM\Column(name="vat_rate", type="decimal", nullable=false, scale=2)
     */
    private $vatRate;
    /**
     * @ORM\Column(name="bank", type="string", length=164, nullable=false)
     */
    private $bank;
    /**
     * @ORM\Column(name="sortCode", type="string", length=64, nullable=false)
     */
    private $sortCode;
    /**
     * @ORM\Column(name="bank_account", type="string", nullable=false)
     */
    private $bankAccount;

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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return InvoiceSettings
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentTerms()
    {
        return $this->paymentTerms;
    }

    /**
     * @param mixed $paymentTerms
     * @return InvoiceSettings
     */
    public function setPaymentTerms($paymentTerms)
    {
        $this->paymentTerms = $paymentTerms;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceLogo()
    {
        return $this->invoiceLogo;
    }

    /**
     * @param mixed $invoiceLogo
     * @return InvoiceSettings
     */
    public function setInvoiceLogo($invoiceLogo)
    {
        $this->invoiceLogo = $invoiceLogo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVatRate()
    {
        return $this->vatRate;
    }

    /**
     * @param mixed $vatRate
     * @return InvoiceSettings
     */
    public function setVatRate($vatRate)
    {
        $this->vatRate = $vatRate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @param mixed $bank
     * @return InvoiceSettings
     */
    public function setBank($bank)
    {
        $this->bank = $bank;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSortCode()
    {
        return $this->sortCode;
    }

    /**
     * @param mixed $sortCode
     * @return InvoiceSettings
     */
    public function setSortCode($sortCode)
    {
        $this->sortCode = $sortCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * @param mixed $bankAccount
     * @return InvoiceSettings
     */
    public function setBankAccount($bankAccount)
    {
        $this->bankAccount = $bankAccount;
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
     * @return InvoiceSettings
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
     * @return InvoiceSettings
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
     * @return InvoiceSettings
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
     * @return InvoiceSettings
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
     * @return InvoiceSettings
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
     * @return InvoiceSettings
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
     * @return InvoiceSettings
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
     * @return InvoiceSettings
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
     * @return InvoiceSettings
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }


}