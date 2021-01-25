<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Table(name="companies_house")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CompaniesHouseRepository")

 */
class CompaniesHouse
{
    public function __construct()
    {
        $this->dateAdded = new \DateTime();
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
     * @ORM\Column(name="date_of_creation", type="datetime",)
     */
    private $dateOfCreation;
    /**
     * @ORM\Column(name="date_of_cessation", type="datetime", nullable=true)
     */
    private $dateOfCessation;
    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title  ;
    /**
     * @ORM\Column(name="company_number", type="string", length=255)
     */
    private $companyNumber  ;
    /**
     * @ORM\Column(name="active", type="string", length=255)
     */
    private $active ;
    /**
     * @ORM\Column(name="add_line1", type="string", length=255, nullable=true)
     */
    private $addLine1  ;
    /**
     * @ORM\Column(name="add_line2", type="string", length=255, nullable=true)
     */
    private $addLine2  ;
    /**
     * @ORM\Column(name="add_line3", type="string", length=255, nullable=true)
     */
    private $addLine3  ;
    /**
     * @ORM\Column(name="add_town", type="string", length=255, nullable=true)
     */
    private $addTown  ;
    /**
     * @ORM\Column(name="add_county", type="string", length=255, nullable=true)
     */
    private $addCounty  ;
    /**
     * @ORM\Column(name="add_postcode", type="string", length=255, nullable=true)
     */
    private $addPostcode  ;
    /**
     * @ORM\Column(name="company_type", type="string", length=255, nullable=true)
     */
    private $companyType;
    /**
     * One companiy has Many officers.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CompaniesHouseOfficers", mappedBy="company")
     */
    private $officers;

    /**
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @param \DateTime $dateAdded
     * @return CompaniesHouse
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;
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
     * @return CompaniesHouse
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateOfCreation()
    {
        return $this->dateOfCreation;
    }

    /**
     * @param mixed $dateOfCreation
     * @return CompaniesHouse
     */
    public function setDateOfCreation($dateOfCreation)
    {
        $this->dateOfCreation = $dateOfCreation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateOfCessation()
    {
        return $this->dateOfCessation;
    }

    /**
     * @param mixed $dateOfCessation
     * @return CompaniesHouse
     */
    public function setDateOfCessation($dateOfCessation)
    {
        $this->dateOfCessation = $dateOfCessation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return CompaniesHouse
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompanyNumber()
    {
        return $this->companyNumber;
    }

    /**
     * @param mixed $companyNumber
     * @return CompaniesHouse
     */
    public function setCompanyNumber($companyNumber)
    {
        $this->companyNumber = $companyNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     * @return CompaniesHouse
     */
    public function setActive($active)
    {
        $this->active = $active;
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
     * @return CompaniesHouse
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
     * @return CompaniesHouse
     */
    public function setAddLine2($addLine2)
    {
        $this->addLine2 = $addLine2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddLine3()
    {
        return $this->addLine3;
    }

    /**
     * @param mixed $addLine3
     * @return CompaniesHouse
     */
    public function setAddLine3($addLine3)
    {
        $this->addLine3 = $addLine3;
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
     * @return CompaniesHouse
     */
    public function setAddTown($addTown)
    {
        $this->addTown = $addTown;
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
     * @return CompaniesHouse
     */
    public function setAddCounty($addCounty)
    {
        $this->addCounty = $addCounty;
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
     * @return CompaniesHouse
     */
    public function setAddPostcode($addPostcode)
    {
        $this->addPostcode = $addPostcode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompanyType()
    {
        return $this->companyType;
    }

    /**
     * @param mixed $companyType
     * @return CompaniesHouse
     */
    public function setCompanyType($companyType)
    {
        $this->companyType = $companyType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOfficers()
    {
        return $this->officers;
    }

    /**
     * @param mixed $officers
     * @return CompaniesHouse
     */
    public function setOfficers($officers)
    {
        $this->officers = $officers;
        return $this;
    }




    /**
     * @return mixed
     */
    public function toArray()
    {
        $array=[
            'id'=>$this->getId(),
            'companyName'=>$this->getTitle(),
            'companyNumber'=>$this->getCompanyNumber(),
            'addLine1'=>$this->getAddLine1(),
            'addLine2'=>$this->getAddLine2(),
            'addLine3'=>$this->getAddLine3(),
            'addTown'=>$this->getAddTown(),
            'addCounty'=>$this->getAddCounty(),
            'addPostcode'=>$this->getAddPostcode(),
            'dateOfCreation'=>$this->getDateOfCreation(),
            'company_type'=>$this->getCompanyType(),

        ];
        return $array;
    }


}