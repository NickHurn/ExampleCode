<?php

// src/AppBundle/Entity/Users.php
namespace AppBundle\Entity;

use AppBundle\Form\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="client_payments")
 * @ORM\Entity(repositoryClass="ClientPaymentRepository")

 */
class ClientPayment
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
     * @ORM\Column(name="amount", type="decimal", nullable=false, scale=2)
     */
    private $amount;

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ClientInvoices", inversedBy="clientPayments")
     * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     */
    private $invoice;

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Payments", inversedBy="clientPayments")
     * @ORM\JoinColumn(name="client_payment_id", referencedColumnName="id")
     */
    private $payment;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ClientPayment
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
     * @return ClientPayment
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     * @return ClientPayment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
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
     * @return ClientPayment
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
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
     * @return ClientPayment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
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