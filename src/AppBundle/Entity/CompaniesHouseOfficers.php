<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Table(name="companies_house_officers")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CompaniesHouseOfficersRepository")
 */
class CompaniesHouseOfficers
{
    public function __construct()
    {
        $this->dateAdded = new \DateTime();
        $this->active = true;
    }
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(name="date_added", type="datetime",)
     */
    private $dateAdded  ;

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CompaniesHouse", inversedBy="officers")
     * @ORM\JoinColumn(name="companies_house_id", referencedColumnName="id")
     */
    private $company;
    /**
     * @ORM\Column(name="premises", type="string", length=255, nullable=true)
     */
    private $premises  ;
    /**
     * @ORM\Column(name="add_line1", type="string", length=255, nullable=true)
     */
    private $addLine1  ;
    /**
     * @ORM\Column(name="add_line2", type="string", length=255, nullable=true)
     */
    private $addLine2  ;
    /**
     * @ORM\Column(name="add_care_of", type="string", length=255, nullable=true)
     */
    private $addCareOf  ;
    /**
     * @ORM\Column(name="add_county", type="string", length=255, nullable=true)
     */
    private $addCounty;
    /**
     * @ORM\Column(name="add_country", type="string", length=255, nullable=true)
     */
    private $addCountry;
    /**
     * @ORM\Column(name="add_town", type="string", length=255, nullable=true)
     */
    private $addTown  ;
    /**
     * @ORM\Column(name="add_pobox", type="string", length=255, nullable=true)
     */
    private $addPOBox  ;
    /**
     * @ORM\Column(name="add_postcode", type="string", length=255, nullable=true)
     */
    private $addPostcode  ;
    /**
     * @ORM\Column(name="appointed_on", type="datetime", nullable=true)
     */
    private $appointedOn  ;
    /**
     * @ORM\Column(name="country_of_residence", type="string", length=255, nullable=true)
     */
    private $countryOfResidence;
    /**
     * @ORM\Column(name="day_of_birth", type="string", nullable=true)
     */
    private $dayOfBirth  ;
    /**
     * @ORM\Column(name="month_of_birth", type="string", nullable=true)
     */
    private $monthOfBirth  ;
    /**
     * @ORM\Column(name="year_of_birth", type="string", nullable=true)
     */
    private $yearOfBirth  ;
    /**
     * @ORM\Column(name="former_forename", type="string", length=255, nullable=true)
     */
    private $formerForename;
    /**
     * @ORM\Column(name="former_surname", type="string", length=255, nullable=true)
     */
    private $formerSurname;
    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;
    /**
     * @ORM\Column(name="nationality", type="string", length=255, nullable=true)
     */
    private $nationality;
    /**
     * @ORM\Column(name="occupation", type="string", length=255, nullable=true)
     */
    private $occupation;
    /**
     * @ORM\Column(name="officer_role", type="string", length=255, nullable=true)
     */
    private $officer_role;
    /**
     * @ORM\Column(name="resigne_on", type="datetime", nullable=true)
     */
    private $resigneOn  ;

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return CompaniesHouseOfficers
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return CompaniesHouseOfficers
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @param mixed $dateAdded
     * @return CompaniesHouseOfficers
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     * @return CompaniesHouseOfficers
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPremises()
    {
        return $this->premises;
    }

    /**
     * @param mixed $premises
     * @return CompaniesHouseOfficers
     */
    public function setPremises($premises)
    {
        $this->premises = $premises;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getAddLine1()
    {
        return $this->addLine1;
    }

    /**
     * @param mixed $addLine1
     * @return CompaniesHouseOfficers
     */
    public function setAddLine1($addLine1)
    {
        $this->addLine1 = $addLine1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddLine2()
    {
        return $this->addLine2;
    }

    /**
     * @param mixed $addLine2
     * @return CompaniesHouseOfficers
     */
    public function setAddLine2($addLine2)
    {
        $this->addLine2 = $addLine2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddCareOf()
    {
        return $this->addCareOf;
    }

    /**
     * @param mixed $addCareOf
     * @return CompaniesHouseOfficers
     */
    public function setAddCareOf($addCareOf)
    {
        $this->addCareOf = $addCareOf;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddCounty()
    {
        return $this->addCounty;
    }

    /**
     * @param mixed $addCounty
     * @return CompaniesHouseOfficers
     */
    public function setAddCounty($addCounty)
    {
        $this->addCounty = $addCounty;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddCountry()
    {
        return $this->addCountry;
    }

    /**
     * @param mixed $addCountry
     * @return CompaniesHouseOfficers
     */
    public function setAddCountry($addCountry)
    {
        $this->addCountry = $addCountry;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddTown()
    {
        return $this->addTown;
    }

    /**
     * @param mixed $addTown
     * @return CompaniesHouseOfficers
     */
    public function setAddTown($addTown)
    {
        $this->addTown = $addTown;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddPOBox()
    {
        return $this->addPOBox;
    }

    /**
     * @param mixed $addPOBox
     * @return CompaniesHouseOfficers
     */
    public function setAddPOBox($addPOBox)
    {
        $this->addPOBox = $addPOBox;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddPostcode()
    {
        return $this->addPostcode;
    }

    /**
     * @param mixed $addPostcode
     * @return CompaniesHouseOfficers
     */
    public function setAddPostcode($addPostcode)
    {
        $this->addPostcode = $addPostcode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAppointedOn()
    {
        return $this->appointedOn;
    }

    /**
     * @param mixed $appointedOn
     * @return CompaniesHouseOfficers
     */
    public function setAppointedOn($appointedOn)
    {
        $this->appointedOn = $appointedOn;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountryOfResidence()
    {
        return $this->countryOfResidence;
    }

    /**
     * @param mixed $countryOfResidence
     * @return CompaniesHouseOfficers
     */
    public function setCountryOfResidence($countryOfResidence)
    {
        $this->countryOfResidence = $countryOfResidence;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDayOfBirth()
    {
        return $this->dayOfBirth;
    }

    /**
     * @param mixed $dayOfBirth
     * @return CompaniesHouseOfficers
     */
    public function setDayOfBirth($dayOfBirth)
    {
        $this->dayOfBirth = $dayOfBirth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMonthOfBirth()
    {
        return $this->monthOfBirth;
    }

    /**
     * @param mixed $monthOfBirth
     * @return CompaniesHouseOfficers
     */
    public function setMonthOfBirth($monthOfBirth)
    {
        $this->monthOfBirth = $monthOfBirth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getYearOfBirth()
    {
        return $this->yearOfBirth;
    }

    /**
     * @param mixed $yearOfBirth
     * @return CompaniesHouseOfficers
     */
    public function setYearOfBirth($yearOfBirth)
    {
        $this->yearOfBirth = $yearOfBirth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormerForename()
    {
        return $this->formerForename;
    }

    /**
     * @param mixed $formerForename
     * @return CompaniesHouseOfficers
     */
    public function setFormerForename($formerForename)
    {
        $this->formerForename = $formerForename;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormerSurname()
    {
        return $this->formerSurname;
    }

    /**
     * @param mixed $formerSurname
     * @return CompaniesHouseOfficers
     */
    public function setFormerSurname($formerSurname)
    {
        $this->formerSurname = $formerSurname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return CompaniesHouseOfficers
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param mixed $nationality
     * @return CompaniesHouseOfficers
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * @param mixed $occupation
     * @return CompaniesHouseOfficers
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOfficerRole()
    {
        return $this->officer_role;
    }

    /**
     * @param mixed $officer_role
     * @return CompaniesHouseOfficers
     */
    public function setOfficerRole($officer_role)
    {
        $this->officer_role = $officer_role;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResigneOn()
    {
        return $this->resigneOn;
    }

    /**
     * @param mixed $resigneOn
     * @return CompaniesHouseOfficers
     */
    public function setResigneOn($resigneOn)
    {
        $this->resigneOn = $resigneOn;
        return $this;
    }

    /**
     * @return mixed
     */
    public function _toArray()
    {
        if (!is_null($this->resigneOn)){
            $resOn = $this->resigneOn->format('d-m-y');
        }else{
            $resOn = null;
        }
        $array=[
            'id'=>$this->id,
            'addLine1'=>$this->addLine1,
            'addLine2'=>$this->addLine2,
            'addCareOf'=>$this->addCareOf,
            'addCounty'=>$this->addCounty,
            'addCountry'=>$this->addCountry,
            'addTown'=>$this->addTown,
            'addPOBox'=>$this->addPOBox,
            'addPostcode'=>$this->addPostcode,
            'appointedOn'=>$this->appointedOn->format('d-m-y'),
            'countryOfResidence'=>$this->countryOfResidence,
            'dayOfBirth'=>$this->dayOfBirth,
            'monthOfBirth'=>$this->monthOfBirth,
            'yearOfBirth'=>$this->yearOfBirth,
            'formerForename'=>$this->formerForename,
            'formerSurname'=>$this->formerSurname,
            'name'=>$this->name,
            'nationality'=>$this->nationality,
            'occupation'=>$this->occupation,
            'officer_role'=>$this->officer_role,
            'resigneOn'=>$resOn,
        ];
        return $array;
    }


}