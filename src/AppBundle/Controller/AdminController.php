<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CompanyDetails;
use AppBundle\Entity\InvoiceSettings;
use AppBundle\Form\ClientSearchForm;
use AppBundle\Form\CompanyDetailsForm;
use AppBundle\Form\InvoiceSettingsForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\IsTrue;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminController extends Controller
{
    /**
     * @Route("admin/dashboard", name="dashboard")
     */
    public function dashboardDetailsAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = NULL;
        $user = $this->getUser();

        $invoiceSettings = $em->getRepository('AppBundle:InvoiceSettings')->find(1);
        $accountBalance = $em->getRepository('AppBundle:ClientAccount')->getClientAccountBalance();
        $unallocatedPaymentBalance = $em->getRepository('AppBundle:ClientPayment')->getUnallocatedPaymentBalance();
        $invoicesDue = $em->getRepository('AppBundle:ClientInvoices')->getInvoicesDue($invoiceSettings);
        $invoicesAmountDue = $em->getRepository('AppBundle:ClientInvoices')->getInvoicesDueAmount($invoiceSettings);
        $invoicesOverdue = $em->getRepository('AppBundle:ClientInvoices')->getInvoicesOverdue();
        $invoicesAmountOverdue = $em->getRepository('AppBundle:ClientInvoices')->getInvoicesOverdueAmount($invoicesOverdue);

        $invoiceHistory = '';

        return $this->render('admin/dashboard.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'user'=>$user,
            'accountBalance'=>$accountBalance,
            'unallocatedPaymentBalance'=>$unallocatedPaymentBalance,
            'invoiceHistory'=>$invoiceHistory,
            'invoicesDue'=>$invoicesDue,
            'invoicesAmountDue'=>$invoicesAmountDue,
            'invoiceSettings'=>$invoiceSettings,
            'invoicesOverdue'=>$invoicesOverdue,
            'invoicesAmountOverdue'=>$invoicesAmountOverdue,
        ]);

    }

    /**
     * @Route("admin/invoiceSettings", name="invoice_settings")
     */
    public function InvoiceSettingsDetailsAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $title = 'Invoice Settings';
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = NULL;
        $user = $this->getUser();
        $invoiceSettings = $this->getInvoiceSettings();

        $invoiceForm = $this->createForm(InvoiceSettingsForm::class, $invoiceSettings);
        $invoiceForm->handleRequest($request);
        if ($invoiceForm->isSubmitted()) {
            if ($invoiceForm->isValid()) {
                if ($invoiceSettings->getPaymentTerms() <= 0){
                    $errorMessage[] = 'Payment terms must be above 1 day.';
                }else {
                    $imagesPath = $this->getParameter('images');
                    $em->getRepository('AppBundle:InvoiceSettings')->saveDocument($invoiceSettings, $request, $imagesPath);
                    $message = 'Invoice Settings updated.';
                }
            }
        }
        $invoiceSettings = $this->getInvoiceSettings();
        return $this->render('admin/invoiceSettings.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'user'=>$user,
            'invoiceSettings'=>$invoiceSettings,
            'invoiceForm'=>$invoiceForm->createView(),
            'title'=>$title,

        ]);

    }
    public function getInvoiceSettings()
    {
        $em = $this->getDoctrine()->getManager();
        $details = $em->getRepository('AppBundle:InvoiceSettings')->find(1);
        if (empty($details)){
            //redirect to be completed
            $details  = new InvoiceSettings();
        }
        return  $details;
    }
    public function getCompanyDetails()
    {
        $em = $this->getDoctrine()->getManager();
        $details = $em->getRepository('AppBundle:CompanyDetails')->find(1);
        if (empty($details)){
            //redirect to be completed
            $details  = new CompanyDetails();
        }
        return  $details;
    }

    /**
     * @Route("admin/companydetails", name="company_details")
     */
    public function CompanyDetailsAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $title = 'Company Details';
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = NULL;
        $user = $this->getUser();
        $details = $this->getCompanyDetails();



        dump($whiteLabel     );exit;

        $form = $this->createForm(CompanyDetailsForm::class, $details);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $uploadedLogo = $request->files->get('company_details_form')['logo'];
                if (!is_null($uploadedLogo)) {
                    $imagesPath = $this->getParameter('images');
                    $logo = $em->getRepository('AppBundle:InvoiceSettings')->saveImage($uploadedLogo, 'companyLogo',$imagesPath);
                    $details->setLogo($logo);
                }
                $em->persist($details);
                $em->flush();
                $message = 'Company Details Updated.';
            }
        }
        $details = $this->getCompanyDetails();
        return $this->render('admin/companyDetails.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'user'=>$user,
            'details'=>$details,
            'form'=>$form->createView(),
            'title'=>$title,
        ]);
    }

    /**
     * @Route("admin/companysetup", name="company_setup")
     */
    public function CompanySetUpAction(Request $request)
    {
        $title = 'Set Up ';
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = NULL;
        $user = $this->getUser();
        $details = $this->getCompanyDetails();
        $invoiceSettings = $this->getInvoiceSettings();
        $invoiceForm = $this->createForm(InvoiceSettingsForm::class, $invoiceSettings);
        $invoiceForm->handleRequest($request);
        $form = $this->createForm(CompanyDetailsForm::class, $details);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $uploadedLogo = $request->files->get('company_details_form')['logo'];
                $uploadedInvoiceLogo = $request->files->get('invoice_settings_form')['invoiceLogo'];
                $imagesPath = $this->getParameter('images');
                if (!is_null($uploadedLogo)) {
                    $logo = $em->getRepository('AppBundle:InvoiceSettings')->saveImage($uploadedLogo, 'companyLogo', $imagesPath);
                    $details->setLogo($logo);
                }
                if (!is_null($uploadedInvoiceLogo)) {
                    $invoiceLogo = $em->getRepository('AppBundle:InvoiceSettings')->saveImage($uploadedInvoiceLogo, 'invoiceLogo', $imagesPath);
                    $invoiceSettings->setInvoiceLogo($invoiceLogo);
                }
                $em->persist($details);
                $em->persist($invoiceSettings);
                $em->flush();
                return $this->redirectToRoute('dashboard');
            }
        }
        $details = $this->getCompanyDetails();
        $invoiceSettings = $this->getInvoiceSettings();
        return $this->render('admin/companySeup.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'user'=>$user,
            'title'=>$title,
            'details'=>$details,
            'form'=>$form->createView(),
            'invoiceForm'=>$invoiceForm->createView(),
            'invoiceSettings' => $invoiceSettings,
        ]);
    }

    public function getDocumentFolder($company, $firstname, $surname){
        if (!is_null($company)){
            $companyName = str_replace(' ', '_', $company);
            $clientDocFolder = strtolower($companyName);
        }else{
            $firstName = str_replace(' ', '_', $firstname);
            $surname = str_replace(' ', '_', $surname);
            $clientDocFolder = strtolower($firstName).'_'.strtolower($surname);
        }
        return $clientDocFolder;
    }

    /**
     * @Route("/admin/accounts/{guid}", name="accounts")
     */
    public function AccountsDetailsAction(Request $request, $guid=null)
    {
        /**
         * @var client Client
         */
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = [];
        $title = 'Client Account';
        $docSavePath = $this->getParameter('domain').'/'.$this->getParameter('client_documents').'/';
        $currentDate = new \DateTime();
        $client = $em->getRepository('AppBundle:Client')->findAll();
        $invoices = $em->getRepository('AppBundle:ClientInvoices')->findAll();
        $InvoiceOverview = $em->getRepository('AppBundle:ClientInvoices')->getAccountOverview($invoices);
        $accountOverview = $em->getRepository('AppBundle:ClientAccount')->findBy([],['dateCreated'=>'ASC']);
        $accountBalance = $em->getRepository('AppBundle:ClientAccount')->getClientAccountBalance();
        $unallocatedPaymentBalance = $em->getRepository('AppBundle:ClientPayment')->getUnallocatedPaymentBalance();
        return $this->render('admin/account.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'client' => $client,
            'title'=>$title,
            'docSavePath'=>$docSavePath,
            'invoices'=>$invoices,
            'currentDate'=>$currentDate,
            'accountOverview'=>$accountOverview,
            'invoiceOverview'=>$InvoiceOverview,
            'accountBalance'=>$accountBalance,
            'unallocatedPaymentBalance'=>$unallocatedPaymentBalance,
        ]);
    }


    /**
     * @Route("admin/clientSearch/{type}", name="client_search")
     */
    public function ClientSearchAction(Request $request, $type)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $title = 'Client Search';
        $message ='';
        $errorMessage = NULL;

        $form = $this->createForm(ClientSearchForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $data=$form->getData();

                if ($type == 'invoice'){
                    return $this->redirectToRoute('client_invoices', ['guid' => $data['client']->getGuid(), 'section' => 'invoices']);
                }
                if ($type == 'payment'){

                    return $this->redirectToRoute('client_payment', ['guid' => $data['client']->getGuid()]);
                }
            }
        }

        return $this->render('admin/clientSearch.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'form'=>$form->createView(),
            'title'=>$title,

        ]);

    }


}
