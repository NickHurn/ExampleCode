<?php

// src/AppBundle/Entity/Users.php
namespace AppBundle\Entity;

use AppBundle\Form\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="payments")
 * @ORM\Entity()

 */
class Payments
{

    public function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->clientPayments = new ArrayCollection();
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
     * @ORM\Column(name="client_guid", type="string", length=255, nullable=false)
     */
    private $clientGuid  ;

    /**
     * @ORM\Column(name="allocated", type="decimal", nullable=true, scale=2)
     */
    private $allocated;

    /**
     * @ORM\Column(name="unallocated", type="decimal", nullable=true, scale=2)
     */
    private $unallocated;


    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ClientPayment", mappedBy="payment")
     */
    private $clientPayments;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Payments
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
     * @return Payments
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
     * @return Payments
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientGuid()
    {
        return $this->clientGuid;
    }

    /**
     * @param mixed $clientGuid
     * @return Payments
     */
    public function setClientGuid($clientGuid)
    {
        $this->clientGuid = $clientGuid;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getClientPayments()
    {
        return $this->clientPayments;
    }

    /**
     * @param mixed $clientPayments
     * @return Payments
     */
    public function setClientPayments($clientPayments)
    {
        $this->clientPayments = $clientPayments;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAllocated()
    {
        return $this->allocated;
    }

    /**
     * @param mixed $allocated
     * @return Payments
     */
    public function setAllocated($allocated)
    {
        $this->allocated = $allocated;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnallocated()
    {
        return $this->unallocated;
    }

    /**
     * @param mixed $unallocated
     * @return Payments
     */
    public function setUnallocated($unallocated)
    {
        $this->unallocated = $unallocated;
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