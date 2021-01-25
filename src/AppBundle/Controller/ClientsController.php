<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ClientContacts;
use AppBundle\Entity\ClientDocuments;
use AppBundle\Entity\ClientInvoices;
use AppBundle\Entity\CompaniesHouse;
use AppBundle\Entity\User;
use AppBundle\Form\ClientContactForm;
use AppBundle\Form\DocumentsForm;
use AppBundle\Form\ClientInvoiceForm;
use AppBundle\Form\PaymentForm;
use http\Params;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\IsTrue;
use AppBundle\Entity\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Twig\Node\IfNode;


class ClientsController extends Controller
{
    /**
     * @Route("/client/dashboard", name="client_dashboard")
     */
    public function FindUsersDetailsAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_CLIENT');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = NULL;
        $user = $this->getUser();
        $title = 'Dashboard';
        $invoiceSettings = $em->getRepository('AppBundle:InvoiceSettings')->find(1);
        $accountBalance = $em->getRepository('AppBundle:ClientAccount')->getClientAccountBalance();
        $unallocatedPaymentBalance = $em->getRepository('AppBundle:ClientPayment')->getUnallocatedPaymentBalance();
        $invoicesDue = $em->getRepository('AppBundle:ClientInvoices')->getInvoicesDue($invoiceSettings);
        $invoicesAmountDue = $em->getRepository('AppBundle:ClientInvoices')->getInvoicesDueAmount($invoiceSettings);
        $invoicesOverdue = $em->getRepository('AppBundle:ClientInvoices')->getInvoicesDue($invoiceSettings);
        $invoicesAmountOverdue = $em->getRepository('AppBundle:ClientInvoices')->getInvoicesDueAmount($invoiceSettings);
        $invoiceHistory = '';
        return $this->render('client/dashboard.html.twig', [
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
            'title'=>$title,
        ]);
    }

    /**
     * @Route("/newclientdetails", name="new_client_details")
     */
    public function NewClientDetailsAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = [];
        $title ='Add New Client';
        $newClient=new Client();
        $clientForm = $this->createForm(\AppBundle\Form\Client::class, $newClient);
        $clientForm->handleRequest($request);
        $companiesHouseModel = $this->get('app.companies_house');
        if ($clientForm->isSubmitted()) {
            if ($clientForm->isValid()) {
                $data=$request->request;


                $clientExists= $em->getRepository('AppBundle:Client')->findOneBy(['company'=>$data->get('client')['company']]);
                if ($clientExists != null){
                    $errorMessage[] = 'Sorry that client already exists';
                }else{
                    if (!is_null($newClient->getFirstname() && !is_null($newClient->getSurname()))) {
                        //is the company number stored against another client?
                        $ch = $em->getRepository('AppBundle:CompaniesHouse')->findOneBy(['companyNumber' => $data->get('companyNumber')]);
                        $companyUsed =  $em->getRepository('AppBundle:CompaniesHouse')->checkCompanyNotAlreadyAssigned($ch);

                        if ($companyUsed === false) {

                            $officerList = $companiesHouseModel->companyOfficersList($ch->getCompanyNumber(), $this->getParameter('companiesHouseAPI'));
                            $officers = [];
                            foreach ($officerList->items as $officer) {
                                $offExists = $em->getRepository('AppBundle:CompaniesHouseOfficers')->findOneBy(['name' => $officer->name]);
                                if (is_null($offExists)) {
                                    $officers[] = $em->getRepository('AppBundle:CompaniesHouseOfficers')->addOfficer($officer, $ch);
                                } else {
                                    $officers[] = $em->getRepository('AppBundle:CompaniesHouseOfficers')->updateOfficers($officer, $offExists);
                                }
                            }
                            $em->getRepository('AppBundle:CompaniesHouse')->saveOfficer($ch, $officers);
                            $client = $em->getRepository('AppBundle:Client')->saveClient($data, $newClient, $ch);
                            $em->getRepository('AppBundle:ClientContacts')->saveClientContact($data, $client);
                            //create user
                            $newUser = new User();
                            $dataArray = [
                                'firstname' => $data->get('client')['firstname'],
                                'surname' => $data->get('client')['surname'],
                                'username' => $data->get('email'),
                            ];
                            $encoder = $this->get('security.password_encoder');
                            $password = $em->getRepository('AppBundle:User')->getPassword($data->get('user'));
                            $encoded = $encoder->encodePassword($newUser, $password);
                            $role = $em->getRepository('AppBundle:Role')->findOneBy(['friendlyName' => 'client']);
                            $guid = $em->getRepository('AppBundle:User')->getGuid($dataArray);
                            $savedUser = $em->getRepository('AppBundle:User')->saveUser($dataArray, $newUser, $encoded, $guid, $role);
                            //send user temp password
                            $url = $this->getParameter('domain') . '/login';
                            $companyDetails = $em->getRepository('AppBundle:CompanyDetails')->find(1);
                            $mail = \Swift_Message::newInstance()
                                ->setSubject('Welcome')
                                ->setFrom($this->getParameter('new_user_email'))
                                ->setTo($savedUser->getUsername())
                                ->setBody(
                                    $body = $this->renderView('templates/newUser.html.twig',
                                        array('name' => $savedUser->getFirstname() . ' ' . $savedUser->getSurname(), 'password' => $password, 'url' => $url, 'companyDetails' => $companyDetails)
                                    ),
                                    'text/html'
                                )
                                ->addPart(
                                    $body = $this->renderView('templates/newUser.html.twig',
                                        array('name' => $savedUser->getFirstname() . ' ' . $savedUser->getSurname(), 'password' => $password, 'url' => $url, 'companyDetails' => $companyDetails)
                                    ),
                                    'text/plain'
                                );
                            $this->get('mailer')->send($mail);
                            return $this->redirectToRoute('client', ['guid' => $client->getGuid(), 'section' => 'details']);
                        }else{
                            $errorMessage[] ='This company is already assigned to '.$companyUsed->DisplayName();
                        }
                    }else{
                        if (is_null($newClient->getFirstname())) {
                            $errorMessage[] ='Please enter the clients firstname';
                        }
                        if(is_null($newClient->getSurname())) {
                            $errorMessage[] ='Please enter the clients surname';
                        }
                    }
                }
            }
        }
        return $this->render('client/newclient.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'clientForm' => $clientForm->createView(),
            'title'=>$title,
        ]);
    }

    /**
     * @Route("/client/findclients", name="find_clients")
     */
    public function FindClientsDetailsAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = NULL;
        $title = 'Find Clients';
        $result = null;
        $form = $this->createForm(\AppBundle\Form\SearchForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $data = $form->getData();

                    $result = $em->getRepository('AppBundle:Client')->findClientsLike($data);
            }
        }
        $clients = $em->getRepository('AppBundle:Client')->findBy(['active'=>1]);
        return $this->render('client//findclient.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'clients' => $clients,
            'title'=>$title,
            'form'=>$form->createView(),
            'result'=>$result,
        ]);
    }

    /**
     * @Route("/client/client/{guid}", name="client")
     */
    public function ClientsDetailsAction(Request $request, $guid=null)
    {
        /**
         * @var client Client
         */
        $this->denyAccessUnlessGranted('ROLE_CLIENT');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = [];
        $clientContactError = null;
        $title = 'Client Details';
        $section = 'details';

        $client = $em->getRepository('AppBundle:Client')->findOneBy(['guid' => $guid]);
        //client details
        $clientForm = $this->createForm(\AppBundle\Form\Client::class, $client);
        $clientForm->handleRequest($request);
        if ($clientForm->isSubmitted()) {
            if ($clientForm->isValid()) {
                $data=$clientForm->getData();
                if ($clientForm->getClickedButton() && 'save' === $clientForm->getClickedButton()->getName()) {
                    $cl = $em->getRepository('AppBundle:Client')->find($data->getId());
                    dump($client, $request->request, $data, $cl);exit;

                    $em->persist($client);
                    $em->flush();
                    $message = 'The client has been updated';
                }
                if ($clientForm->getClickedButton() && 'remove' === $clientForm->getClickedButton()->getName()) {
                    $client->setActive(0);
                    $em->persist($client);
                    $em->flush();
                    $message = 'The client has been removed';
                }
                $message = 'Client '.$client->displayName().' has been saved.';
            }
        }
        return $this->render('client/client.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'client' => $client,
            'title'=>$title,
            'form' => $clientForm->createView(),
            'section'=>$section,
        ]);
    }

    /**
     * @Route("/client/clientContacts/{guid}", name="client_contacts")
     */
    public function ClientContactsDetailsAction(Request $request, $guid=null)
    {
        /**
         * @var client Client
         */
        $this->denyAccessUnlessGranted('ROLE_CLIENT');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = [];
        $clientContactError = null;
        $title = 'Client Contacts';
        $section = 'contacts';
        $client = $em->getRepository('AppBundle:Client')->findOneBy(['guid' => $guid]);
        //client contacts
        $clientContactForm = $this->createForm(ClientContactForm::class);
        $clientContactForm->handleRequest($request);
        if ($clientContactForm->isSubmitted()) {
            if ($clientContactForm->isValid()) {
                $data = $clientContactForm->getData();
                if (is_null($data['id'])) {
                    $cc = new ClientContacts();
                    $cc->setClient($client);
                } else {
                    $cc = $em->getRepository('AppBundle:ClientContacts')->find($data['id']);
                }
                if ($clientContactForm->getClickedButton() && 'remove' === $clientContactForm->getClickedButton()->getName()) {
                    $em->getRepository('AppBundle:ClientContacts')->deleteClientContact($cc);
                    $message = 'The contact has been removed';
                }
                if ($clientContactForm->getClickedButton() && 'submit' === $clientContactForm->getClickedButton()->getName()) {
                    $clientContactError = $em->getRepository('AppBundle:ClientContacts')->checkClientContact($data);
                    if (is_null($clientContactError)) {
                        $em->getRepository('AppBundle:ClientContacts')->saveClientContact($cc, $data);
                        unset($clientContactForm);
                        $clientContactForm = $this->createForm(ClientContactForm::class);
                        $clientContactForm->handleRequest($request);
                        $message = 'The contact has been updated';
                    }
                }
            }
        }
        $client = $em->getRepository('AppBundle:Client')->findOneBy(['guid' => $guid]);
        return $this->render('client//clientContacts.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'client' => $client,
            'title'=>$title,
            'clientContactForm' => $clientContactForm->createView(),
            'section'=>$section,
        ]);
    }

    /**
     * @Route("/client/clientDocuments/{guid}", name="client_documents")
     */
    public function ClientsDocumentsDetailsAction(Request $request, $guid=null)
    {
        /**
         * @var client Client
         */
        $this->denyAccessUnlessGranted('ROLE_CLIENT');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = [];
        $clientContactError = null;
        $title = 'Client Documents';
        $section = 'docs';
        $client = $em->getRepository('AppBundle:Client')->findOneBy(['guid' => $guid]);
        $docSavePath = $this->getParameter('domain').'/'.$this->getParameter('client_documents').'/';
        $rootDocPath = $this->getParameter('root_document_path').'/';
        $docEntity = new ClientDocuments();
        $clientDocForm = $this->createForm(DocumentsForm::class, $docEntity);
        $clientDocForm->handleRequest($request);
        if ($clientDocForm->isSubmitted()) {
            if ($clientDocForm->isValid()) {
                $em->getRepository('AppBundle:ClientDocuments')->saveDocument($docEntity, $request->files->get('documents_form')['document'], $client,$rootDocPath);
                return $this->redirectToRoute('client_documents', ['guid' => $client->getGuid()]);
            }else{
                $errors = $clientDocForm->getErrors(true);
                foreach ($errors as $e){
                    $errorMessage[]=$e->getMessage();
                }
            }
        }
        $clientDocForm = $this->createForm(DocumentsForm::class, $docEntity);
        $clientDocForm->handleRequest($request);
        $client = $em->getRepository('AppBundle:Client')->findOneBy(['guid' => $guid]);
        return $this->render('client//clientDocuments.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'client' => $client,
            'title'=>$title,
            'clientDocForm' => $clientDocForm->createView(),
            'docPath'=>$docSavePath,
            'section'=>$section,
        ]);
    }

    /**
     * @Route("/client/clientServices/{guid}", name="client_services")
     */
    public function ClientServicesDetailsAction(Request $request, $guid=null)
    {
        /**
         * @var client Client
         */
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = [];
        $clientContactError = null;
        $title = 'Client Services';
        $section = 'services';
        $client = $em->getRepository('AppBundle:Client')->findOneBy(['guid' => $guid]);
        return $this->render('client//clientServices.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'client' => $client,
            'title'=>$title,
            'section'=>$section,
        ]);
    }

    /**
     * @Route("/client/clientInvoices/{guid}", name="client_invoices")
     */
    public function ClientInvoicesDetailsAction(Request $request, $guid=null)
    {
        /**
         * @var client Client
         */
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = [];
        $clientContactError = null;
        $title = 'Client Invoices';
        $section = 'invoices';
        $client = $em->getRepository('AppBundle:Client')->findOneBy(['guid' => $guid]);
        $docSavePath = $this->getParameter('domain').'/'.$this->getParameter('client_documents').'/';
        $rootDocPath = $this->getParameter('root_document_path').'/';
        //client invoices
        $invoiceEntity = new ClientInvoices();
        $clientInvoiceForm = $this->createForm(ClientInvoiceForm::class, $invoiceEntity);
        $clientInvoiceForm->handleRequest($request);
        $invoiceSettings = $em->getRepository('AppBundle:InvoiceSettings')->find(1);
        if ($clientInvoiceForm->isSubmitted()) {
            if ($clientInvoiceForm->isValid()) {

                $newInvoice = $em->getRepository('AppBundle:ClientInvoices')->saveInvoice($client, $invoiceEntity, $request->request);
                $file = 'invoice-'.$invoiceEntity->getId();
                $createdInvoice = $em->getRepository('AppBundle:ClientInvoices')->addPdfToDocs($client, $newInvoice,$file);

                $this->get('knp_snappy.pdf')->generateFromHtml(
                    $this->renderView( 'invoice/invoicePDFTemplate.html.twig',
                        [
                            'client'=>$createdInvoice->getClient(),
                            'invoice'=>$invoiceEntity,
                            'invoiceSettings'=>$invoiceSettings,
                            'logoPath'=>'/usr/share/nginx/html/adaption/web/images/',
                        ]
                    ),

                    $rootDocPath.'invoice-'.$invoiceEntity->getId().'.pdf'
                );

                unset($clientInvoiceForm);
                return $this->redirectToRoute('client_invoices', ['guid' => $client->getGuid(), 'section' => 'invoices']);
            }
        }
        $invoices = $em->getRepository('AppBundle:ClientInvoices')->findBy(['client'=>$client],['id'=>'desc']);
        $invoiceSettings = $em->getRepository('AppBundle:InvoiceSettings')->find(1);
        return $this->render('client//clientInvoices.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'client' => $client,
            'title'=>$title,
            'clientInvoiceForm' => $clientInvoiceForm->createView(),
            'docPath'=>$docSavePath,
            'section'=>$section,
            'invoices'=>$invoices,
            'invoiceSettings'=>$invoiceSettings,
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
     * @Route("/clientgetcontact", name="client_get_contact")
     */
    public function clientGetContact (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $data=$em->getRepository('AppBundle:ClientContacts')->find($id);
        return $this->json(array(
            'status' => 'ok',
            'data'=>$data->_toArray(),
        ));
    }
    /**
     * @Route("/deleteDocument", name="delete_document")
     */
    public function deleteDocument (Request $request)
    {
        /**
         * var $data ClientDocuments
         */
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $data=$em->getRepository('AppBundle:ClientDocuments')->find($id);

        if (is_null($data->getDocumentType())){
            $em->getRepository('AppBundle:ClientDocuments')->deleteDocument($data);
        }elseif ($data->getDocumentType() == 'invoice'){
            return $this->json(array(
                'status' => 'error',
                'error'=>'You can not delete and invoice',
            ));
        }
        return $this->json(array(
            'status' => 'ok',
        ));
    }

    /**
     * @Route("/getInvoiceDetails", name="get_invoice_details")
     */
    public function getInvoiceDetails (Request $request)
    {
        /**
         * var $data ClientDocuments
         */
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $invoice= $em->getRepository('AppBundle:ClientInvoices')->find($id);
        $client = $em->getRepository('AppBundle:Client')->findOneBy(['guid'=>$invoice->getClientGuid()]);
        $invoiceSettings = $em->getRepository('AppBundle:InvoiceSettings')->find(1);
        return $this->json(array(
            'status' => 'ok',
            'invoice'=>$invoice->_toArray(),
            'client'=>$client->_toArray(),
            'invoiceSettings'=>$invoiceSettings->getInvoiceLogo()
        ));
    }

    /**
     * @Route("/client/clientAccount/{guid}", name="client_account")
     */
    public function ClientsAccountDetailsAction(Request $request, $guid=null)
    {
        /**
         * @var client Client
         */
        $this->denyAccessUnlessGranted('ROLE_CLIENT');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = [];
        $title = 'Client Account';
        $section = 'account';
        $docSavePath = $this->getParameter('domain').'/'.$this->getParameter('client_documents').'/';
        $currentDate = new \DateTime();
        $client = $em->getRepository('AppBundle:Client')->findOneBy(['guid' => $guid]);
        $invoices = $em->getRepository('AppBundle:ClientInvoices')->findBy(['client'=>$client]);
        $InvoiceOverview = $em->getRepository('AppBundle:ClientInvoices')->getAccountOverview($invoices);
        $accountOverview = $em->getRepository('AppBundle:ClientAccount')->findBy(['client'=>$client],['dateCreated'=>'ASC']);
        $accountBalance = $em->getRepository('AppBundle:ClientAccount')->getClientAccountBalance($client);
        $unallocatedPaymentBalance = $em->getRepository('AppBundle:ClientPayment')->getUnallocatedPaymentBalance($client);
        return $this->render('client//clientAccount.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'client' => $client,
            'title'=>$title,
            'docSavePath'=>$docSavePath,
            'invoices'=>$invoices,
            'section'=>$section,
            'currentDate'=>$currentDate,
            'accountOverview'=>$accountOverview,
            'invoiceOverview'=>$InvoiceOverview,
            'accountBalance'=>$accountBalance,
            'unallocatedPaymentBalance'=>$unallocatedPaymentBalance,

        ]);
    }

    /**
     * @Route("/client/clientPayment/{guid}", name="client_payment")
     */
    public function ClientPaymentDetailsAction(Request $request, $guid)
    {
        /**
         * @var client Client
         */
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = [];
        $title = 'Client Payment';

        $client = $em->getRepository('AppBundle:Client')->findOneBy(['guid' => $guid]);
        $outstandingInvoices = $em->getRepository('AppBundle:ClientInvoices')->findBy(['paid'=>false, 'client'=>$client]);
        $accountBalance = $em->getRepository('AppBundle:ClientAccount')->getClientAccountBalance($client);
        $paymentForm = $this->createForm(PaymentForm::class);
        $paymentForm->handleRequest($request);
        $unallocatedPayments = $em->getRepository('AppBundle:ClientPayment')->getUnallocatedPaymentBalance($client);

        if ($paymentForm->isSubmitted()) {
            if ($paymentForm->isValid()) {
                $paymentAmount= $paymentForm->getData();
                $invoiceAmounts = $request->request;
                $invoiceArray=[];

                foreach ($invoiceAmounts as $key => $value) {
                    $result = substr($key, 0, 10);
                    if ($result == 'payInvoice') {
                        $invoiceArray[] = [
                            'invoice' => $value,
                            'amount' => $invoiceAmounts->get('invoiceAmount'.$value),
                        ];
                    }
                }
                $processedPayment=$em->getRepository('AppBundle:ClientPayment')->processPaymentAmount($paymentAmount, $client);
                $em->getRepository('AppBundle:ClientPayment')->processClientInvoicePayment($client, $invoiceArray,  $processedPayment);
                return $this->redirectToRoute('client_account', ['guid' => $client->getGuid(), 'section' => 'invoices']);
            }
        }

        return $this->render('client//clientPayments.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'client' => $client,
            'title'=>$title,
            'paymentForm'=>$paymentForm->createView(),
            'outstandingInvoices'=>$outstandingInvoices,
            'accountBalance'=>$accountBalance,
            'unallocatedPayments'=>$unallocatedPayments,


        ]);
    }

    /**
     * @Route("/client/clientPaymentAllocation/{guid}", name="client_payment_allocation")
     */
    public function ClientPaymentAllocationDetailsAction(Request $request, $guid=null)
    {
        /**
         * @var client Client
         */
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = [];
        $title = 'Client Payment Allocation';

        $client = $em->getRepository('AppBundle:Client')->findOneBy(['guid' => $guid]);
        $outstandingInvoices = $em->getRepository('AppBundle:ClientInvoices')->findBy(['paid'=>false]);
        $paymentForm = $this->createForm(PaymentForm::class);
        $paymentForm->handleRequest($request);
        $unallocatedPayments = $em->getRepository('AppBundle:ClientPayment')->getUnallocatedPaymentBalance($client);

        if ($paymentForm->isSubmitted()) {
            if ($paymentForm->isValid()) {
                $invoiceAmounts = $request->request;

                $invoice = $em->getRepository('AppBundle:ClientInvoices')->find($invoiceAmounts->get('invoice'));
                $em->getRepository('AppBundle:ClientPayment')->allocateUnallocatedPaymentBalance($client, $invoice);
                $unallocatedPayments = $em->getRepository('AppBundle:ClientPayment')->getUnallocatedPaymentBalance($client);
                if ($unallocatedPayments <=0){
                    return $this->redirectToRoute('client_account', ['guid' => $client->getGuid(), 'section' => 'invoices']);
                }
            }
        }

        return $this->render('client//clientPaymentAllocation.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'client' => $client,
            'title'=>$title,
            'paymentForm'=>$paymentForm->createView(),
            'outstandingInvoices'=>$outstandingInvoices,
            'unallocatedPayments'=>$unallocatedPayments,


        ]);
    }

    /**
     * @Route("/client/clientNewInvoices/{guid}", name="client_new_invoices")
     */
    public function ClientNewInvoicesDetailsAction(Request $request, $guid)
    {
        /**
         * @var client Client
         */
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = [];
        $clientContactError = null;
        $title = 'New Client Invoices';
        $client = $em->getRepository('AppBundle:Client')->findOneBy(['guid' => $guid]);
        $docSavePath = $this->getParameter('domain').'/'.$this->getParameter('client_documents').'/';
        $rootDocPath = $this->getParameter('root_document_path').'/';

        //client invoices
        $invoiceEntity = new ClientInvoices();
        $clientInvoiceForm = $this->createForm(ClientInvoiceForm::class, $invoiceEntity);
        $clientInvoiceForm->handleRequest($request);
        $invoiceSettings = $em->getRepository('AppBundle:InvoiceSettings')->find(1);
        if ($clientInvoiceForm->isSubmitted()) {
            if ($clientInvoiceForm->isValid()) {
                $newInvoice = $em->getRepository('AppBundle:ClientInvoices')->saveInvoice($client, $invoiceEntity, $request->request, $invoiceSettings);
                $file = 'invoice-'.$invoiceEntity->getId();
                $createdInvoice = $em->getRepository('AppBundle:ClientInvoices')->addPdfToDocs($client, $newInvoice,$file);
                $this->get('knp_snappy.pdf')->generateFromHtml(
                    $this->renderView( 'invoice/invoicePDFTemplate.html.twig',
                        [
                            'client'=>$createdInvoice->getClient(),
                            'invoice'=>$invoiceEntity,
                            'invoiceSettings'=>$invoiceSettings,
                            'logoPath'=>$this->getParameter('images'),
                            'companyDetails'=> $em->getRepository('AppBundle:CompanyDetails')->find(1),
                        ]
                    ),
                    $rootDocPath.'invoice-'.$invoiceEntity->getId().'.pdf'
                );

                unset($clientInvoiceForm);
                return $this->redirectToRoute('client_invoices', ['guid' => $client->getGuid(), 'section' => 'invoices']);
            }
        }


        return $this->render('client//clientNewInvoices.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'client' => $client,
            'title'=>$title,
            'clientInvoiceForm' => $clientInvoiceForm->createView(),
            'docPath'=>$docSavePath,
            'invoiceSettings'=>$invoiceSettings,
        ]);
    }
    /**
     * @Route("/getallclientcontacts", name="get_all_client_contacts")
     */
    public function getAllClientContacts (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $data=$em->getRepository('AppBundle:ClientContacts')->findBy(['client'=>$id]);
        $array = [];
        foreach ($data as $d){
            $array[]=$d->_toArray();
        }
        return $this->json(array(
            'status' => 'ok',
            'data'=>$array,
        ));
    }

    /**
     * @Route("/companieshouse/companyofficers/{guid}", name="client_officers")
     */
    public function companyOfficersAction(Request $request, $guid)
    {
        $this->denyAccessUnlessGranted('ROLE_CLIENT');
        $em = $this->getDoctrine()->getManager();
        $messages ='';
        $errorMessage = NULL;
        $title='Officers';
        $section = 'officers';
        $clientDetails = $em->getRepository('AppBundle:Client')->findOneBy(['guid' => $guid]);
        return $this->render('client/clientOfficers.html.twig', [
            'message'=>$messages,
            'errorMessage'=>$errorMessage,
            'title' => $title,
            'client'=>$clientDetails,
            'section'=>$section,

        ]);
    }

    /**
     * @Route("/saveclientCompanieshousedetails", name="save_client_companies_house_details")
     */
    public function saveClientCompaniesHouseDetails (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $coNo = $request->query->get('coNo');
        $companiesHouseModel = $this->get('app.companies_house');
        $ch = $em->getRepository('AppBundle:CompaniesHouse')->findOneBy(['companyNumber'=>$coNo]);
        $officerList = $companiesHouseModel->companyOfficersList($ch->getCompanyNumber(),$this->getParameter('companiesHouseAPI'));
        $officers = [];
        foreach ($officerList->items as $officer){
            $offExists = $em->getRepository('AppBundle:CompaniesHouseOfficers')->findOneBy(['name'=>$officer->name]);
            if(is_null($offExists)){
                $officers[]=$em->getRepository('AppBundle:CompaniesHouseOfficers')->addOfficer($officer, $ch);
            }else{
                $officers[]=$em->getRepository('AppBundle:CompaniesHouseOfficers')->updateOfficers($officer, $offExists);
            }
        }
        $em->getRepository('AppBundle:CompaniesHouse')->saveOfficer($ch, $officers);
        $client = $em->getRepository('AppBundle:Client')->find($id);
        $chNoExistsAgainstClient = $em->getRepository('AppBundle:Client')->findBy(['companyHouse'=>$ch]);
        if (empty($chNoExistsAgainstClient)){
            $em->getRepository('AppBundle:Client')->addCompanyHouseDetailsToClient($client, $ch);
            return $this->json(array(
                'status' => 'ok',
            ));
        }else{
            return $this->json(array(
                'status' => 'error',
            ));
        }
    }


}
