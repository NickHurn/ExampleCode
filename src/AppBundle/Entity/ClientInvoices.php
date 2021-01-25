<?php

// src/AppBundle/Entity/Users.php
namespace AppBundle\Entity;

use AppBundle\Form\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="client_invoices")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ClientInvoicesRespository")

 */
class ClientInvoices
{
    public function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->paid = false;
    }

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(name="invoice_guid", type="string", length=255, nullable=false)
     */
    private $invoiceGuid  ;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
     * @ORM\JoinColumn(name="client", referencedColumnName="id")
     */
    private $client;
    /**
     * @ORM\Column(name="document_name", type="string", length=64, nullable=false)
     */
    private $documentName;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false  )
     */
    private $dateCreated;
    /**
     * @ORM\Column(name="days", type="float", nullable=false)
     */
    private $days;
    /**
     * @ORM\Column(name="day_rate", type="decimal", nullable=false, scale=2)
     */
    private $dayRate;
    /**
     * @ORM\Column(name="description", type="string", length=64, nullable=false)
     */
    private $description;
    /**
     * @ORM\Column(name="days2", type="float", nullable=true)
     */
    private $days2;
    /**
     * @ORM\Column(name="day_rate2", type="decimal", nullable=true, scale=2)
     */
    private $dayRate2;
    /**
     * @ORM\Column(name="description2", type="string", length=64, nullable=true)
     */
    private $description2;
    /**
     * @ORM\Column(name="days3", type="float", nullable=true)
     */
    private $days3;
    /**
     * @ORM\Column(name="day_rate3", type="decimal", nullable=true, scale=2)
     */
    private $dayRate3;
    /**
     * @ORM\Column(name="description3", type="string", length=64, nullable=true)
     */
    private $description3;
    /**
     * @ORM\Column(name="days4", type="float", nullable=true)
     */
    private $days4;
    /**
     * @ORM\Column(name="day_rate4", type="decimal", nullable=true, scale=2)
     */
    private $dayRate4;
    /**
     * @ORM\Column(name="description4", type="string", length=64, nullable=true)
     */
    private $description4;
    /**
     * @ORM\Column(name="days5", type="float", nullable=true)
     */
    private $days5;
    /**
     * @ORM\Column(name="day_rate5", type="decimal", nullable=true, scale=2)
     */
    private $dayRate5;
    /**
     * @ORM\Column(name="description5", type="string", length=64, nullable=true)
     */
    private $description5;

    /**
     * @ORM\Column(name="amount", type="decimal", nullable=false, scale=2)
     */
    private $amount;
    /**
     * @ORM\Column(name="amount2", type="decimal", nullable=true, scale=2)
     */
    private $amount2;
    /**
     * @ORM\Column(name="amount3", type="decimal", nullable=true, scale=2)
     */
    private $amount3;
    /**
     * @ORM\Column(name="amount4", type="decimal", nullable=true, scale=2)
     */
    private $amount4;
    /**
     * @ORM\Column(name="amount5", type="decimal", nullable=true, scale=2)
     */
    private $amount5;
    /**
     * @ORM\Column(name="paid", type="boolean")
     */
    private $paid;
    /**
     * @ORM\Column(name="paid_amount", type="decimal", nullable=true, scale=2)
     */
    private $paidAmount;
    /**
     * @ORM\Column(name="discount", type="decimal", nullable=true, scale=2)
     */
    private $discount;
    /**
     * @ORM\Column(name="sub_total", type="decimal", nullable=false, scale=2)
     */
    private $subTotal;
    /**
     * @ORM\Column(name="vat_rate", type="decimal", nullable=false, scale=2)
     */
    private $vatRate;
    /**
     * @ORM\Column(name="vat", type="boolean", nullable=false)
     */
    private $vat;
    /**
     * @ORM\Column(name="vat_amount", type="decimal", nullable=false, scale=2)
     */
    private $vatAmount;
    /**
     * @ORM\Column(name="total_payable", type="decimal", nullable=false, scale=2)
     */
    private $totalPayable;
    /**
     * @ORM\Column(name="payment_terms_date", type="datetime", nullable=false  )
     */
    private $paymentTermsDate;

    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ClientPayment", mappedBy="invoice")
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
     * @return ClientInvoices
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
     * @return ClientInvoices
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getDocumentName()
    {
        return $this->documentName;
    }

    /**
     * @param mixed $documentName
     * @return ClientInvoices
     */
    public function setDocumentName($documentName)
    {
        $this->documentName = $documentName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return ClientInvoices
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @return ClientInvoices
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param mixed $days
     * @return ClientInvoices
     */
    public function setDays($days)
    {
        $this->days = $days;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDayRate()
    {
        return $this->dayRate;
    }

    /**
     * @param mixed $dayRate
     * @return ClientInvoices
     */
    public function setDayRate($dayRate)
    {
        $this->dayRate = $dayRate;
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
     * @return ClientInvoices
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * @param mixed $paid
     * @return ClientInvoices
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     * @return ClientInvoices
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubTotal()
    {
        return $this->subTotal;
    }

    /**
     * @param mixed $subTotal
     * @return ClientInvoices
     */
    public function setSubTotal($subTotal)
    {
        $this->subTotal = $subTotal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalPayable()
    {
        return $this->totalPayable;
    }

    /**
     * @param mixed $totalPayable
     * @return ClientInvoices
     */
    public function setTotalPayable($totalPayable)
    {
        $this->totalPayable = $totalPayable;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentTermsDate()
    {
        return $this->paymentTermsDate;
    }

    /**
     * @param mixed $paymentTermsDate
     * @return ClientInvoices
     */
    public function setPaymentTermsDate($paymentTermsDate)
    {
        $this->paymentTermsDate = $paymentTermsDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDays2()
    {
        return $this->days2;
    }

    /**
     * @param mixed $days2
     * @return ClientInvoices
     */
    public function setDays2($days2)
    {
        $this->days2 = $days2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDayRate2()
    {
        return $this->dayRate2;
    }

    /**
     * @param mixed $dayRate2
     * @return ClientInvoices
     */
    public function setDayRate2($dayRate2)
    {
        $this->dayRate2 = $dayRate2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription2()
    {
        return $this->description2;
    }

    /**
     * @param mixed $description2
     * @return ClientInvoices
     */
    public function setDescription2($description2)
    {
        $this->description2 = $description2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDays3()
    {
        return $this->days3;
    }

    /**
     * @param mixed $days3
     * @return ClientInvoices
     */
    public function setDays3($days3)
    {
        $this->days3 = $days3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDayRate3()
    {
        return $this->dayRate3;
    }

    /**
     * @param mixed $dayRate3
     * @return ClientInvoices
     */
    public function setDayRate3($dayRate3)
    {
        $this->dayRate3 = $dayRate3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription3()
    {
        return $this->description3;
    }

    /**
     * @param mixed $description3
     * @return ClientInvoices
     */
    public function setDescription3($description3)
    {
        $this->description3 = $description3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDays4()
    {
        return $this->days4;
    }

    /**
     * @param mixed $days4
     * @return ClientInvoices
     */
    public function setDays4($days4)
    {
        $this->days4 = $days4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDayRate4()
    {
        return $this->dayRate4;
    }

    /**
     * @param mixed $dayRate4
     * @return ClientInvoices
     */
    public function setDayRate4($dayRate4)
    {
        $this->dayRate4 = $dayRate4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription4()
    {
        return $this->description4;
    }

    /**
     * @param mixed $description4
     * @return ClientInvoices
     */
    public function setDescription4($description4)
    {
        $this->description4 = $description4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDays5()
    {
        return $this->days5;
    }

    /**
     * @param mixed $days5
     * @return ClientInvoices
     */
    public function setDays5($days5)
    {
        $this->days5 = $days5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDayRate5()
    {
        return $this->dayRate5;
    }

    /**
     * @param mixed $dayRate5
     * @return ClientInvoices
     */
    public function setDayRate5($dayRate5)
    {
        $this->dayRate5 = $dayRate5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription5()
    {
        return $this->description5;
    }

    /**
     * @param mixed $description5
     * @return ClientInvoices
     */
    public function setDescription5($description5)
    {
        $this->description5 = $description5;
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
     * @return ClientInvoices
     */
    public function setVatRate($vatRate)
    {
        $this->vatRate = $vatRate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount2()
    {
        return $this->amount2;
    }

    /**
     * @param mixed $amount2
     * @return ClientInvoices
     */
    public function setAmount2($amount2)
    {
        $this->amount2 = $amount2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount3()
    {
        return $this->amount3;
    }

    /**
     * @param mixed $amount3
     * @return ClientInvoices
     */
    public function setAmount3($amount3)
    {
        $this->amount3 = $amount3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount4()
    {
        return $this->amount4;
    }

    /**
     * @param mixed $amount4
     * @return ClientInvoices
     */
    public function setAmount4($amount4)
    {
        $this->amount4 = $amount4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount5()
    {
        return $this->amount5;
    }

    /**
     * @param mixed $amount5
     * @return ClientInvoices
     */
    public function setAmount5($amount5)
    {
        $this->amount5 = $amount5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVatAmount()
    {
        return $this->vatAmount;
    }

    /**
     * @param mixed $vatAmount
     * @return ClientInvoices
     */
    public function setVatAmount($vatAmount)
    {
        $this->vatAmount = $vatAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceGuid()
    {
        return $this->invoiceGuid;
    }

    /**
     * @param mixed $invoiceGuid
     * @return ClientInvoices
     */
    public function setInvoiceGuid($invoiceGuid)
    {
        $this->invoiceGuid = $invoiceGuid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaidAmount()
    {
        return $this->paidAmount;
    }

    /**
     * @param mixed $paidAmount
     * @return ClientInvoices
     */
    public function setPaidAmount($paidAmount)
    {
        $this->paidAmount = $paidAmount;
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
     * @return ClientInvoices
     */
    public function setClientPayments($clientPayments)
    {
        $this->clientPayments = $clientPayments;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * @param mixed $vat
     * @return ClientInvoices
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
        return $this;
    }



    /**
     * @return mixed
     */
    public function _toArray()
    {
        $array=[
            'id'=>$this->getId(),
            'docName'=>$this->getDocumentName(),
            'date'=>$this->getDateCreated()->format('jS F Y'),
            'description'=>$this->getDescription(),
            'days'=>$this->getDays(),
            'dayRate'=>$this->getDayRate(),
            'amount'=>$this->getAmount(),
            'description2'=>$this->getDescription2(),
            'days2'=>$this->getDays2(),
            'dayRate2'=>$this->getDayRate2(),
            'amount2'=>$this->getAmount2(),
            'description3'=>$this->getDescription3(),
            'days3'=>$this->getDays3(),
            'dayRate3'=>$this->getDayRate3(),
            'amount3'=>$this->getAmount3(),
            'description4'=>$this->getDescription4(),
            'days4'=>$this->getDays4(),
            'dayRate4'=>$this->getDayRate4(),
            'amount4'=>$this->getAmount4(),
            'description5'=>$this->getDescription5(),
            'days5'=>$this->getDays5(),
            'dayRate5'=>$this->getDayRate5(),
            'amount5'=>$this->getAmount5(),
            'discount'=>$this->getDiscount(),
            'subTotal'=>$this->getSubTotal(),
            'totalPayable'=>$this->getTotalPayable(),
            'paymentTermsDate'=>$this->getPaymentTermsDate()->format('jS F Y'),
            'vatRate'=>$this->getVatRate(),
            'vatAmount'=>$this->getVatAmount(),
        ];
        return $array;
    }

    /**
     * @return mixed
     */
    public function _accToArray()
    {
        $array=[
            'id'=>$this->getId(),
            'docName'=>$this->getDocumentName(),
            'date'=>$this->getDateCreated()->format('jS F Y'),
            'totalPayable'=>$this->getTotalPayable(),
        ];
        return $array;
    }
}