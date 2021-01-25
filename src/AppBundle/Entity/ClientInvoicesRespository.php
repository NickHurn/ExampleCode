<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class ClientInvoicesRespository extends EntityRepository
{
    public function saveInvoice(Client $client, ClientInvoices $invoiceEntity, $request, InvoiceSettings $invoiceSettings)
    {
        $em = $this->getEntityManager();
        $date = new \DateTime();
        $currentDateTime = time();
        if (!is_null($client->getCompany())){
            $name=$client->getCompany();
        }else{
            $name=$client->getFirstname() . $client->getSurname();
        }
        $vatRate = 0.00;
        $uniqueId = md5( $name.$currentDateTime);
        $invoiceEntity->setPaymentTermsDate($date->modify('+'.$request->get('paymentTerms').' days'));
        $invoiceEntity->setClient($client);
        $invoiceEntity->setDocumentName('invoice');
        $invoiceEntity->setInvoiceGuid($uniqueId);
        $invoiceEntity->setAmount($invoiceEntity->getDayRate()*$invoiceEntity->getDays());
        $invoiceEntity->setAmount2($invoiceEntity->getDayRate2()*$invoiceEntity->getDays2());
        $invoiceEntity->setAmount3($invoiceEntity->getDayRate3()*$invoiceEntity->getDays3());
        $invoiceEntity->setAmount4($invoiceEntity->getDayRate4()*$invoiceEntity->getDays4());
        $invoiceEntity->setAmount5($invoiceEntity->getDayRate5()*$invoiceEntity->getDays5());
        $subTotal = $invoiceEntity->getAmount()+$invoiceEntity->getAmount2()+$invoiceEntity->getAmount3()+$invoiceEntity->getAmount4()+$invoiceEntity->getAmount5();
        $invoiceEntity->setSubTotal($subTotal-$invoiceEntity->getDiscount());
        if ($invoiceEntity->getVat()===true){
            $invoiceEntity->setVatRate($invoiceSettings->getVatRate());
            $vatRate = $invoiceSettings->getVatRate();
        }
        $invoiceEntity->setVatRate($vatRate);
        $vatAmount = ($vatRate/100)*$invoiceEntity->getSubTotal();
        $invoiceEntity->setVatAmount($vatAmount);
        $invoiceEntity->setTotalPayable($invoiceEntity->getSubTotal()+$invoiceEntity->getVatAmount());
        $em->persist($invoiceEntity);
        $em->flush();

        $em->getRepository('AppBundle:ClientAccount')->createInvoiceAccountEntry($client, $invoiceEntity);

        return $invoiceEntity;
    }

    public function addPdfToDocs ($client, ClientInvoices $newInvoice, $file)
    {

        $em = $this->getEntityManager();
        $doc = new ClientDocuments();
        $doc->setClient($client);
        $doc->setDocumentName($file);
        $doc->setDocument($file.'.pdf');
        $doc->setMimeType('pdf');
        $doc->setDocumentType('invoice');
        $doc->setDescription($newInvoice->getDescription());
        $em->persist($doc);
        $em->flush();
        return $doc;
    }

    public function getAccountOverview ($invoices )
    {
        /**
         * @var ClientInvoices $i
         */
        $em = $this->getEntityManager();
        $tao = 0;
        $tio = 0;
        $tap = 0;
        $tip = 0;
        $date = new \DateTime();
        foreach ($invoices as $i){
            if ($i->getPaidAmount() < $i->getTotalPayable()){
                $amountOS = $i->getTotalPayable() - $i->getPaidAmount();
                $tao  = $tao+$amountOS;
                $tio++;
                $amountOS=0;
            }
            if ($i->getPaidAmount() < $i->getTotalPayable() && $i->getPaymentTermsDate()->format('-d-m-y') < $date->format('-d-m-y')   ){
                $amountOS2 = $i->getTotalPayable() - $i->getPaidAmount();
                $tap  = $tap+$amountOS2;
                $tip++;
                $amountOS2=0;
            }
        }
        $overviewArray =[
            'totalAmountOutstanding'=>$tao,
            'totalInvoicesOutstanding'=>$tio,
            'totalAmountPassedDueDate'=>$tap,
            'totalInvoicesPassedDueDate'=>$tip,
        ];

        return $overviewArray;
    }

    public function getInvoicesDue (InvoiceSettings $invoiceSettings)
    {
        $em = $this->getEntityManager();
        $paymentTerms = $invoiceSettings->getPaymentTerms();
        $pd = $paymentTerms+1;
        $dateXDaysAgo = date('Y-m-d', strtotime('+'.$pd.' days'));
        $dateXDaysAgo = new \DateTime($dateXDaysAgo);
        $todaysDate = new \DateTime();
        $paid = 0;
        $repository = $em->getRepository('AppBundle:ClientInvoices');

        $query = $repository->createQueryBuilder('ci')
            ->Where('ci.paymentTermsDate <= :termsDate')
            ->andWhere('ci.paymentTermsDate >= :todaysDate')
            ->andWhere('ci.paid = :paid')
            ->setParameter('termsDate', $dateXDaysAgo)
            ->setParameter('paid', $paid)
            ->setParameter('todaysDate', $todaysDate)
            ->getQuery() ->getResult();
        return $query;
    }
    public function getInvoicesDueAmount (InvoiceSettings $invoiceSettings )
    {
        $query = $this->getInvoicesDue($invoiceSettings);
        $amountDue = 0;
        /**
         * @var $q ClientInvoices
         */
        foreach ($query as $q){
            $due = $q->getTotalPayable() - $q->getPaidAmount();
            $amountDue = $amountDue+$due;
        }

        return $amountDue;

    }

    public function getInvoicesOverdue ()
    {
        $em = $this->getEntityManager();
        $date = date('Y-m-d');
        $date = new \DateTime($date);
        $paid = 0;
        $repository = $em->getRepository('AppBundle:ClientInvoices');
        $query = $repository->createQueryBuilder('ci')
            ->Where('ci.paymentTermsDate <= :termsDate')
            ->andWhere('ci.paid = :paid')
            ->setParameter('termsDate', $date)
            ->setParameter('paid', $paid)
            ->getQuery() ->getResult();
        return $query;

    }
    public function getInvoicesOverdueAmount ($overdueInvoices )
    {
        if (empty($overdueInvoices)){
            return 0;
        }
        $amountDue = 0;
        /**
         * @var $q ClientInvoices
         */
        foreach ($overdueInvoices as $q){
            $due = $q->getTotalPayable() - $q->getPaidAmount();
            $amountDue = $amountDue+$due;
        }

        return $amountDue;

    }
}