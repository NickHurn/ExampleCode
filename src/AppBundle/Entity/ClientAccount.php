<?php

// src/AppBundle/Entity/Users.php
namespace AppBundle\Entity;

use AppBundle\Form\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="client_account")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ClientAccountRespository")

 */
class ClientAccount
{

    public function __construct()
    {
        $this->dateCreated = new \DateTime();
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
     * @ORM\Column(name="dr", type="decimal", nullable=true, scale=2)
     */
    private $dr;
    /**
     * @ORM\Column(name="cr", type="decimal", nullable=true, scale=2)
     */
    private $cr;

    /**
     * @ORM\OneToOne(targetEntity="ClientInvoices")
     * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     */
    private $invoice;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Payments")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $payment;

    /**
     * @ORM\Column(name="account_type", type="string", length=255, nullable=false)
     */
    private $accountType  ;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
     * @ORM\JoinColumn(name="client", referencedColumnName="id")
     */
    private $client;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ClientAccount
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return ClientAccount
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDr()
    {
        return $this->dr;
    }

    /**
     * @param mixed $dr
     * @return ClientAccount
     */
    public function setDr($dr)
    {
        $this->dr = $dr;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCr()
    {
        return $this->cr;
    }

    /**
     * @param mixed $cr
     * @return ClientAccount
     */
    public function setCr($cr)
    {
        $this->cr = $cr;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @param mixed $invoice
     * @return ClientAccount
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * @param mixed $accountType
     * @return ClientAccount
     */
    public function setAccountType($accountType)
    {
        $this->accountType = $accountType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param mixed $payment
     * @return ClientAccount
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
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
     * @return ClientAccount
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return mixed
     */
    public function _toArray()
    {
        $array=[
            'id'=>$this->getId(),
            'date'=>$this->getDateCreated()->format('jS F Y'),
            'amount'=>$this->getAmount(),
        ];
        return $array;
    }

}