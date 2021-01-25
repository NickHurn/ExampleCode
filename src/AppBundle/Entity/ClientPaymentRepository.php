<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class ClientPaymentRepository extends EntityRepository
{
    public function getAccount(Client $client)
    {
        $em = $this->getEntityManager();
        $data = [];
        $inv = $em
            ->createQuery('SELECT i.id as invNo, i.totalPayable as amount, i.documentName, i.dateCreated, i.paid
                FROM AppBundle:ClientInvoices i 
                WHERE i.clientGuid =:guid
                order by i.id DESC'
            )->setParameters(array("guid" => $client->getGuid()))
            ->getResult();
        $payment = $em
            ->createQuery('SELECT p.invNo, p.amount, p.documentName, p.dateCreated
                FROM AppBundle:ClientPayment p 
                WHERE p.clientGuid =:guid
                order by p.invNo DESC'
            )->setParameters(array("guid" => $client->getGuid()))
            ->getResult();
        $data = array_merge($inv, $payment);
        return $data;
    }

    public function processClientInvoicePayment(Client $client, $invoiceArray,  Payments $processedPayment)
    {
        $em = $this->getEntityManager();
        $clientPaymentArray=[];
        foreach ($invoiceArray as $payment){
            $invDetails = $em->getRepository('AppBundle:ClientInvoices')->find($payment['invoice']);
            $amountOtstanding = $invDetails->getTotalPayable() - $invDetails->getPaidAmount();
            if ($amountOtstanding >= $payment['amount']){
                $invDetails->setPaidAmount($invDetails->getPaidAmount()+$payment['amount']) ;
                if ($invDetails->getPaidAmount() == $invDetails->getTotalPayable()){
                    $invDetails->setPaid(true);
                }
                $em->persist($invDetails);
            }

            if ($processedPayment->getUnallocated() >= $payment['amount']){
                $processedPayment->setAllocated($payment['amount']);
                $unallocated =
                $processedPayment->setUnallocated( $processedPayment->getUnallocated()-$payment['amount']);
                $em->persist($processedPayment);
            }

            $cp = new ClientPayment();
            $cp->setAmount($payment['amount']);
            $cp->setInvoice($invDetails);
            $cp->setPayment($processedPayment);
            $em->persist($cp);
            $em->flush();
            $clientPaymentArray[]=$cp;
        }
        $processedPayment->setClientPayments($clientPaymentArray);
        $em->persist($processedPayment);
        $em->flush();
    }

    public function processPaymentAmount($amount, Client $client)
    {
        $em = $this->getEntityManager();
        $payment = new Payments();
        $payment->setAmount($amount['paymentAmount']);
        $payment->setClientGuid($client->getGuid());
        $payment->setUnallocated($amount['paymentAmount']);
        $em->persist($payment);
        $em->flush();
        $em->getRepository('AppBundle:ClientAccount')->createPaymentAccountEntry($client, $payment, 'Payment');
        return $payment;
    }


    public function getPaymentBalance(Client $client){
        $em = $this->getEntityManager();
        $invoices = $em->getRepository('AppBundle:ClientInvoices')->findBy(['clientGuid'=>$client->getGuid()]);
        $outstanding = 0;
        foreach ($invoices as $inv){
            $ttl = $inv->getTotalPayable();
            $paid = $inv->getPaidAmount();

            $outstanding = $outstanding-($ttl-$paid);
        }
       return $outstanding;

    }

    public function getUnallocatedPaymentBalance(Client $client=null){
        $em = $this->getEntityManager();
        if (is_null($client)){
            $payment = $em->getRepository('AppBundle:Payments')->findAll();
        }else{
            $payment = $em->getRepository('AppBundle:Payments')->findBy(['clientGuid'=>$client->getGuid()]);
        }

        $outstanding = 0;
        foreach ($payment as $p){
            if ($p->getUnallocated() > 0){
                $outstanding = $outstanding+$p->getUnallocated();
            }
        }
        return $outstanding;

    }

    public function allocateUnallocatedPaymentBalance(Client $client, ClientInvoices $invoice){
        $em = $this->getEntityManager();
        $payment = $em->getRepository('AppBundle:Payments')->findBy(['clientGuid'=>$client->getGuid()]);
        $outstanding = 0;
        foreach ($payment as $p){
            $invoiceOs = $invoice->getTotalPayable()-$invoice->getPaidAmount();
            $unallocatedAmount = $p->getUnallocated();
            if ($p->getUnallocated() > 0){
                if ($invoiceOs > $unallocatedAmount){
                    $invoice->setPaidAmount($invoice->getPaidAmount()+$unallocatedAmount) ;
                    if ($invoice->getPaidAmount() == $invoice->getTotalPayable()){
                        $invoice->setPaid(true);
                    }
                    $em->persist($invoice);

                    $p->setAllocated($p->getAllocated()+$unallocatedAmount);
                    $p->setUnallocated( $p->getUnallocated()-$unallocatedAmount);
                    $em->persist($p);

                    $cp = new ClientPayment();
                    $cp->setAmount($unallocatedAmount);
                    $cp->setInvoice($invoice);
                    $cp->setPayment($p);
                    $em->persist($cp);

                    $em->flush();
                }
            }
        }
        return $outstanding;

    }
}
