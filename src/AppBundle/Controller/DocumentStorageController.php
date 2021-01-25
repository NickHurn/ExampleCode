<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ClientDocuments;
use AppBundle\Entity\Documents;
use AppBundle\Form\ClientSearchForm;
use AppBundle\Form\ContactSearchForm;
use AppBundle\Form\DocumentsForm;
use AppBundle\Form\EmailForm;
use AppBundle\Form\SearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DocumentStorageController extends Controller
{
    /**
     * @Route("documentStorage/documents", name="document_storage_documents")
     */
    public function documentsAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_CLIENT');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = NULL;
        $title = 'Document Repository';
        $docSavePath = $this->getParameter('domain').'/'.$this->getParameter('client_documents').'/';
        $rootDocPath = $this->getParameter('root_document_path') . '/';

        $emailForm = $this->createForm(EmailForm::class);
        $emailForm->handleRequest($request);
        $clientSearchForm = $this->createForm(ClientSearchForm::class);
        $clientSearchForm->handleRequest($request);
        $contactSearchForm = $this->createForm(ContactSearchForm::class);
        $contactSearchForm->handleRequest($request);
        if ($emailForm->isSubmitted()) {
            if ($emailForm->isValid()) {
                $emailData = $emailForm->getData();
                $contactData = $em->getRepository('AppBundle:ClientContacts')->find($request->request->get('contact_search_form')['contact']);
                $doc = $em->getRepository('AppBundle:Documents')->find($request->request->get('docId'));
                $client = $em->getRepository('AppBundle:Client')->find($request->request->get('client_search_form')['client']);
                //save doc to clients docs
                $em->getRepository('AppBundle:ClientDocuments')->copyDocTemplateAndSave($client->displayName().' '.$doc->getDocumentName(), $doc, $rootDocPath, $client);
                //send email with the attachment
                $mail = \Swift_Message::newInstance()
                    ->setSubject($emailData['subject'])
                    ->setFrom($this->getParameter('new_user_email'))
                    ->setTo($contactData->getEmail())
                    ->setBody(
                        $body = "<p>The document ".$doc->getDocumentName()." has been added to you documents. </p><p>".$emailData['body']."</p>",
                        'text/html'
                    )
                    ->addPart(
                        $body = $emailData['body'],
                        'text/plain'
                    )
                    ;
                $this->get('mailer')->send($mail);
                return $this->redirectToRoute('client_documents', ['guid' => $client->getGuid(), 'section' => 'documents']);


            }
        }

        $docs = $em->getRepository('AppBundle:Documents')->findAll();
        return $this->render('documentStorage/documents.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'title'=>$title,
            'docPath'=>$docSavePath,
            'docs'=>$docs,
            'emailForm'=>$emailForm->createView(),
            'clientSearchForm'=>$clientSearchForm->createView(),
            'contactSearchForm'=>$contactSearchForm->createView(),
        ]);
    }

    /**
     * @Route("documentStorage/delete", name="document_storage_delete")
     */
    public function deleteDocument (Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $data=$em->getRepository('AppBundle:Documents')->find($id);
        $em->getRepository('AppBundle:Documents')->deleteDocument($data);

        return $this->json(array(
            'status' => 'ok',
        ));
    }

    /**
     * @Route("documentStorage/documentedit/{id}", name="document_edit")
     */
    public function documentEditAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = NULL;
        $title = 'Document Edit';
        $doc = $em->getRepository('AppBundle:Documents')->find($id);
        $form = $this->createForm(DocumentsForm::class, $doc);
        $form->handleRequest($request);
        $emailForm = $this->createForm(EmailForm::class);
        $emailForm->handleRequest($request);
        $clientSearchForm = $this->createForm(ClientSearchForm::class);
        $clientSearchForm->handleRequest($request);
        $contactSearchForm = $this->createForm(ContactSearchForm::class);
        $contactSearchForm->handleRequest($request);
        $rootDocPath = $this->getParameter('root_document_path') . '/';
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $fileData = $request->files->get('documents_form')['document'];
                $em->getRepository('AppBundle:Documents')->saveDocument($doc, $fileData, $rootDocPath);
                return $this->redirectToRoute('document_storage_documents');
            }
        }
        if ($emailForm->isSubmitted()) {
            if ($emailForm->isValid()) {
                $emailData = $emailForm->getData();
                $contactData = $em->getRepository('AppBundle:ClientContacts')->find($request->request->get('contact_search_form')['contact']);
                $doc = $em->getRepository('AppBundle:Documents')->find($request->request->get('docId'));
                $client = $em->getRepository('AppBundle:Client')->find($request->request->get('client_search_form')['client']);
                //save doc to clients docs
                $em->getRepository('AppBundle:ClientDocuments')->copyDocTemplateAndSave($client->displayName().' '.$doc->getDocumentName(), $doc, $rootDocPath, $client);
                //send email with the attachment
                $mail = \Swift_Message::newInstance()
                    ->setSubject($emailData['subject'])
                    ->setFrom($this->getParameter('new_user_email'))
                    ->setTo($contactData->getEmail())
                    ->setBody(
                        $body = $emailData['body'],
                        'text/html'
                    )
                    ->addPart(
                        $body = $emailData['body'],
                        'text/plain'
                    )
                    ->attach(
                        \Swift_Attachment::fromPath($this->getParameter('root_document_path').'/'.$doc->getDocumentName())
                    );
                $this->get('mailer')->send($mail);
                return $this->redirectToRoute('client_documents', ['guid' => $client->getGuid(), 'section' => 'documents']);


            }
        }
        return $this->render('documentStorage/documentEdit.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'title'=>$title,
            'form'=>$form->createView(),
            'doc'=>$doc,
            'emailForm'=>$emailForm->createView(),
            'clientSearchForm'=>$clientSearchForm->createView(),
            'contactSearchForm'=>$contactSearchForm->createView(),
        ]);
    }

    /**
     * @Route("documentStorage/documentadd", name="document_add")
     */
    public function documentAddAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = NULL;
        $title = 'New Document';

        $doc = new Documents();
        $form = $this->createForm(DocumentsForm::class, $doc);
        $form->handleRequest($request);
        $rootDocPath = $this->getParameter('root_document_path') . '/';
        $newDoc = new Documents();
        $form = $this->createForm(DocumentsForm::class, $newDoc);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $docExists = $em->getRepository('AppBundle:Documents')->checkDocumentExists($newDoc);
                if (is_null($docExists)) {

                    $fileData = $request->files->get('documents_form')['document'];
                    $em->getRepository('AppBundle:Documents')->saveDocument($newDoc, $fileData, $rootDocPath);
                    return $this->redirectToRoute('document_storage_documents');
                }else{
                    $errorMessage = $docExists;
                }
            }
        }
        return $this->render('documentStorage/documentAdd.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'title'=>$title,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("documentstorage/savedocumenttoclient", name="save_document_to_client")
     */
    public function saveDocumentToClientDocument (Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $client = $this->getUser()->getClient();
        $doc = $em->getRepository('AppBundle:Documents')->find($id);

        $docExists = $em->getRepository('AppBundle:ClientDocuments')->findOneBy(['document'=>$doc->getDocument()]);
        if(!is_null($docExists)){
            return $this->json(array(
                'status' => 'error',
            ));

        }else {
            //save doc to clients docs
            $rootDocPath = $this->getParameter('root_document_path') . '/';
            $em->getRepository('AppBundle:ClientDocuments')->copyDocTemplateAndSave($client->displayName() . ' ' . $doc->getDocumentName(), $doc, $rootDocPath, $client);
            return $this->json(array(
                'status' => 'ok',
            ));
        }
    }




}
