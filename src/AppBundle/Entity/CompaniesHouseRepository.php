<?php

namespace AppBundle\Entity;

use AppBundle\Form\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class CompaniesHouseRepository extends EntityRepository
{


    public function removeCompany(CompaniesHouse $data)
    {
        $em = $this->getEntityManager();
        $em->remove($data);
        $em->flush();
    }


    public function saveCompany($data, CompaniesHouse $comp = null)
    {
        dump($data);exit;
        //save all companies house results in the companies house entity
        $em = $this->getEntityManager();
        if (is_null($comp)) {
            $comp = new CompaniesHouse();
        }
        $comp->setTitle($data->title);
        $comp->setActive($data->company_status);
        $comp->setCompanyNumber($data->company_number);
        $comp->setDateOfCreation(new \DateTime($data->date_of_creation));
        $comp->setAddLine1($data->address->premises . ' ' . $data->address->address_line_1);
        $comp->setCompanyType($data->company_type);
        if (isset($data->address->address_line_2)) {
            $comp->setAddLine2($data->address->address_line_2);
        }
        $comp->setAddTown($data->address->locality);
        if (isset($data->address->region)) {
            $comp->setAddCounty($data->address->region);
        }
        if (isset($data->address->postal_code)) {
            $comp->setAddPostcode($data->address->postal_code);
        }
        if (isset($data->date_of_cessation)){
            $comp->setDateOfCessation(new \DateTime($data->date_of_cessation));
        }
        $comp->setDateAdded(new \DateTime());
        $em->persist($comp);
        $em->flush();
        return $comp;
    }

    public function saveOfficer(CompaniesHouse $chDetails, $officers)
    {

        $em = $this->getEntityManager();
        $chDetails->setOfficers($officers);
        $em->persist($chDetails);
        $em->flush();
    }

    public function checkCompanyNotAlreadyAssigned (CompaniesHouse $ch)
    {
        $em = $this->getEntityManager();
        $used = $em->getRepository('AppBundle:Client')->findOneBy(['companyHouse'=>$ch]);
        if (empty($used)){
            return false;
        }
        return $used;
    }

}