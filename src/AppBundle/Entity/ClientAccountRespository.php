<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class ClientAccountRespository extends EntityRepository
{
    public function createInvoiceAccountEntry(Client $client, ClientInvoices $invoiceEntity)
    {
        $em = $this->getEntityManager();

        $acc = new ClientAccount();
        $acc->setDr($invoiceEntity->getTotalPayable());
        $acc->setAccountType('Invoice');
        $acc->setInvoice($invoiceEntity);
        $acc->setClient($client);
        $em->persist($acc);
        $em->flush();

        return $invoiceEntity;
    }

    public function createPaymentAccountEntry(Client $client, Payments $payment, $type)
    {
        $em = $this->getEntityManager();
        $acc = new ClientAccount();
        $acc->setCr($payment->getAmount());
        $acc->SetAccountType($type);
        $acc->setClient($client);
        $acc->setPayment($payment);
        $em->persist($acc);
        $em->flush();
    }


    public function getClientAccountBalance(Client $client=Null)
    {
        /**
         * @var ClientAccount $acc
         */
        $em = $this->getEntityManager();
        if(is_null($client) ){
            $accountOverview = $em->getRepository('AppBundle:ClientAccount')->findBy([], ['dateCreated' => 'ASC']);
        }else {
            $accountOverview = $em->getRepository('AppBundle:ClientAccount')->findBy(['client' => $client], ['dateCreated' => 'ASC']);
        }
        $dr = 0;
        $cr=0;
        foreach ($accountOverview as $acc){
           $dr= $acc->getDr() + $dr;
           $cr=$acc->getCr() + $cr;
        }
        $balance=[
            'cr'=>$cr,
            'dr'=>$dr,
            'balance'=>$cr - $dr,
        ];

        return $balance;
    }

    public function getUnallocatedPayments(Client $client){
        $em = $this->getEntityManager();
        $data = $em->getRepository('AppBundle:ClientAccount')->findBy(['client'=>$client, 'accountType'=>'Payment']);
        $unallocatedFunds = 0;
        foreach ($data as $i){
            if (count($i->getPayment()->getClientPayments()) == 0) {

                $unallocatedFunds = $unallocatedFunds+$i->getCr();
            }
        }
        return $unallocatedFunds;

    }

}