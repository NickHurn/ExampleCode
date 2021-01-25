<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ClientContacts;
use AppBundle\Entity\ClientDocuments;
use AppBundle\Entity\ClientInvoices;
use AppBundle\Entity\User;
use AppBundle\Form\ClientContactForm;
use AppBundle\Form\DocumentsForm;
use AppBundle\Form\ClientInvoiceForm;
use AppBundle\Form\PaymentForm;
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


class CompaniesHouseController extends Controller
{
    /**
     * @Route("/companieshouse/companySearch", name="company_search")
     */
    public function companySearch (Request $request)
    {
        $searchTerm = $request->query->get('search');
        $apiKey = $this->getParameter('companiesHouseAPI');
        $companiesHouseModel = $this->get('app.companies_house');
        $result = $companiesHouseModel->findCompany($searchTerm,$apiKey);
        return $this->json(array(
            'status' => 'ok',
            'data' => $result->items,
        ));
    }

    /**
     * @Route("/companieshouse/getCompaniesHouseRecord", name="companies_house_record")
     */
    public function getCompaniesHouseRecord (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $searchTerm = $request->query->get('search');
        $data = $em->getRepository('AppBundle:CompaniesHouse')->findOneBy(['companyNumber'=>$searchTerm]);
        return $this->json(array(
            'status' => 'ok',
            'data' =>  $data->toArray(),
        ));
    }

    /**
     * @Route("/companieshouse/refreshCompanyData", name="refresh_company_data")
     */
    public function refreshCompanyData (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $apiKey = $this->getParameter('companiesHouseAPI');
        $companiesHouseModel = $this->get('app.companies_house');
        $searchTerm = $request->query->get('coNo');
        $companiesHouseRecord = $em->getRepository('AppBundle:CompaniesHouse')->findOneBy(['companyNumber'=>$searchTerm]) ;
        $data = $companiesHouseModel->refreshCompany($searchTerm,$apiKey);
        $chData = $em->getRepository('AppBundle:CompaniesHouse')->saveCompany($data['company'][0]->items[0], $companiesHouseRecord);
        $officers = [];
        foreach ($data['officers'][0]->items as $officer){
            $offExists = $em->getRepository('AppBundle:CompaniesHouseOfficers')->findOneBy(['name'=>$officer->name]);
            if(is_null($offExists)){
                $officers[]=$em->getRepository('AppBundle:CompaniesHouseOfficers')->addOfficer($officer, $chData);
            }else{
                $officers[]=$em->getRepository('AppBundle:CompaniesHouseOfficers')->updateOfficers($officer, $offExists);
            }
        }
        $em->getRepository('AppBundle:CompaniesHouse')->saveOfficer($chData, $officers);

        return $this->json(array(
            'status' => 'ok',
            'message' =>  'The company Details updated from companies house..',
        ));
    }



    /**
     * @Route("/companieshouse/getofficerdetails", name="get_officer_details")
     */
    public function getOfficerDetails (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $officerId = $request->query->get('id');

        $officerDetails = $em->getRepository('AppBundle:CompaniesHouseOfficers')->find($officerId);
        return $this->json(array(
            'status' => 'ok',
            'data' =>  $officerDetails->_toArray(),
        ));
    }


}
