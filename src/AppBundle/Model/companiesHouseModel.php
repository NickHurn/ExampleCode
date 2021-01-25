<?php

namespace AppBundle\Model;

use AppBundle\Entity\CompaniesHouse;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;


class companiesHouseModel extends Controller
{
    /**
     * @var $em ObjectManager
     */
    private $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @throws \Exception
     */
    public function refreshCompany($searchTerm, $apiKey)
    {
        $data = [];
        //refresh compnay details
        $companyData = $this->getCompany($searchTerm, $apiKey);
        $data['company']=[$companyData];
        //get officers
        $officers = $this->companyOfficersList($searchTerm, $apiKey);
        $data['officers']=[$officers];

        return $data;
    }

    /**
     * @throws \Exception
     */
    public function findCompany($searchTerm, $apiKey)
    {
        //set serach string

        $data = $this->getCompany($searchTerm, $apiKey);
        //$this->companyOfficersList($data, $apiKey);
        //for each result save to entity
        foreach ($data->items as $d){
            if (isset($d->company_number)) {
                //check if companies house record exists
                $exists = $this->em->getRepository('AppBundle:CompaniesHouse')->findOneBy(['companyNumber' => $d->company_number]);
                //if it dies exists check to see if its older than 3 months since it was saved.
                if ($exists) {
                    //get date of 3 months ago
                    $date = date("d-F-y", strtotime("-3 Months"));
                    $date = new \DateTime($date);
                    $date = $date->format("d-F-y");
                    $dateSaved = $exists->getDateAdded()->format("d-F-y");
                    if ($dateSaved < $date) {
                        $this->em->getRepository('AppBundle:CompaniesHouse')->saveCompany($d, $exists);
                    }
                } else {
                    $this->em->getRepository('AppBundle:CompaniesHouse')->saveCompany($d);

                }
            }
        }
        return $data;
    }

    /**
     * @throws \Exception
     */
    public function getCompany($searchTerm, $apiKey)
    {
        $searchTerm = str_replace(' ', '+', $searchTerm);
        //call companies house
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.companieshouse.gov.uk/search?q=".$searchTerm."&items_per_page=10&start_index=0");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ":" . "");
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            $result= curl_error($ch);
        }
        curl_close ($ch);
        $data = json_decode($result);
        return $data;
    }

    /**
     * @throws \Exception
     */
    public function companyOfficersList($searchTerm, $apiKey)
    {
        //call companies house
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.companieshouse.gov.uk/company/".$searchTerm."/officers");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ":" . "");
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            $result= curl_error($ch);
        }
        curl_close ($ch);
        $data = json_decode($result);
        return $data;
    }
}