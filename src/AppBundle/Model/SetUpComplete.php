<?php
namespace AppBundle\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SetUpComplete extends Controller
{
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    public function companyDetailsCheck ()
    {

        $error = false;
        $companyDetails = $this->em->getRepository('AppBundle:CompanyDetails')->find(1);
        $invoiceSettings = $this->em->getRepository('AppBundle:InvoiceSettings')->find(1);
        $errorDetails=[];
        if (is_null($companyDetails)){
            $errorDetails = ['companyDetailsEmpty'=>true];
            return true;
        }
        if (is_null($invoiceSettings)){
            $errorDetails = ['invoiceSettingsEmpty'=>true];
            return true;
        }
        if (is_null($companyDetails->getCoName())){
            $errorDetails = ['coName'=>true];
            $error=true;
        }
        if (is_null($companyDetails->getCoNumber())){
            $errorDetails = ['companyNo'=>true];
            $error=true;
        }
        if (is_null($invoiceSettings->getInvoiceLogo())){
            $errorDetails = ['invoiceLogo'=>true];
            $error=true;
        }
        if (is_null($invoiceSettings->getAddLine1())){
            $errorDetails = ['invoiceAddLine1'=>true];
            $error=true;
        }
        if (is_null($invoiceSettings->getAddTown())){
            $errorDetails = ['invoiceAddTown'=>true];
            $error=true;
        }
        if (is_null($invoiceSettings->getAddPostcode())){
            $errorDetails = ['invoiceAddPostcode'=>true];
            $error=true;
        }
        if (is_null($invoiceSettings->getBank())){
            $errorDetails = ['invoiceBank'=>true];
            $error=true;
        }
        if (is_null($invoiceSettings->getBankAccount())){
            $errorDetails = ['invoiceBankAccount'=>true];
            $error=true;
        }
        if (is_null($invoiceSettings->getSortCode())){
            $errorDetails = ['invoiceSortCode'=>true];
            $error=true;
        }
        if (is_null($invoiceSettings->getPaymentTerms())){
            $errorDetails = ['invoicePaymentTerms'=>true];
            $error=true;
        }
        if (is_null($invoiceSettings->getVatRate())){
            $errorDetails = ['invoiceVatRate'=>true];
            $error=true;
        }


        return $error;
    }


}