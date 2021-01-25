<?php

namespace AppBundle\Entity;

use AppBundle\Form\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class CompaniesHouseOfficersRepository extends EntityRepository
{
    public function removeOfficer(CompaniesHouseOfficers $data)
    {
        $em = $this->getEntityManager();
        $em->remove($data);
        $em->flush();
    }

    public function setOfficerEntity ($off, CompaniesHouseOfficers $officer)
    {
        if (isset($off->address->care_of)){
            $officer->setAddCareOf($off->care_of);
        }
        if (isset($off->address->po_box)){
            $officer->setAddPOBox($off->po_box);
        }
        if (isset($off->address->premises)){
            $officer->setPremises($off->address->premises);
        }
        if (isset($off->address->address_line_1)){
            $officer->setAddLine1($off->address->address_line_1);
        }
        if (isset($off->address->address_line_2)){
            $officer->setAddLine2($off->address->address_line_2);
        }
        if (isset($off->address->locality)){
            $officer->setAddTown($off->address->locality);
        }
        if (isset($off->address->region)){
            $officer->setAddCounty($off->address->region);
        }
        if (isset($off->address->postal_code)){
            $officer->setAddPostcode($off->address->postal_code);
        }
        if (isset($off->address->country)){
            $officer->setAddCountry($off->address->country);
        }
        if (isset($off->appointed_on)){
            $officer->setAppointedOn(new \DateTime($off->appointed_on));
        }
        if (isset($off->country_of_residence)){
            $officer->setCountryOfResidence($off->country_of_residence);
        }
        if (isset($off->resigned_on) && !is_null($off->resigned_on)){
            $officer->setResigneOn(new \DateTime($off->resigned_on));
        }
        if (isset($off->date_of_birth->day)){
            $officer->setDayOfBirth($off->date_of_birth->day);
        }
        if (isset($off->date_of_birth->month)){
            $officer->setMonthOfBirth($off->date_of_birth->month);
        }
        if (isset($off->date_of_birth->year)){
            $officer->setYearOfBirth($off->date_of_birth->year);
        }
        if (isset($off->former_names->forenames)){
            $officer->setFormerForename($off->former_names->forenames);
        }
        if (isset($off->former_names->surname)){
            $officer->setFormerSurname($off->former_names->surname);
        }
        if (isset($off->name)) {
            $officer->setName($off->name);
        }
        if (isset($off->nationality)){
            $officer->setNationality($off->nationality);
        }
        if (isset($off->occupation)){
            $officer->setOccupation($off->occupation);
        }
        if (isset($off->officer_role)){
            $officer->setOfficerRole($off->officer_role);
        }

        return $officer;
    }

    public function addOfficer($off, CompaniesHouse $chData)
    {
        $em = $this->getEntityManager();
        $officer = new CompaniesHouseOfficers();
        $officer->setCompany($chData);
        $officer=$this->setOfficerEntity($off, $officer, $chData);
        $em->persist($officer);
        $em->flush();
        return $officer;

    }

    public function updateOfficers($off, CompaniesHouseOfficers $officer)
    {
        $em = $this->getEntityManager();
        $officer=$this->setOfficerEntity($off, $officer);
        $em->persist($officer);
        $em->flush();
        return $officer;
    }
}