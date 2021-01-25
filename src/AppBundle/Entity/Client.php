<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Table(name="clients")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ClientRespository")

 */
class Client
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
     * @ORM\Column(name="client_type", type="string", length=1, nullable=false)
     */
    private $clientType  ;
    /**
     * @ORM\Column(name="date_added", type="datetime",)
     */
    private $dateAdded  ;
    /**
     * @ORM\Column(name="company", type="string", length=255, nullable=true)
     */
    private $company  ;
    /**
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname  ;
    /**
     * @ORM\Column(name="surname", type="string", length=255, nullable=true)
     */
    private $surname  ;
    /**
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image  ;
    /**
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url  ;
    /**
     * @ORM\Column(name="active", type="boolean", length=255)
     */
    private $active;
    /**
     * @ORM\Column(name="add_line1", type="string", length=255, nullable=false)
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
     * @ORM\Column(name="add_town", type="string", length=255, nullable=false)
     */
    private $addTown  ;
    /**
     * @ORM\Column(name="add_county", type="string", length=255, nullable=true)
     */
    private $addCounty  ;
    /**
     * @ORM\Column(name="add_postcode", type="string", length=255, nullable=false)
     */
    private $addPostcode  ;

    /**
     * One Product has One Shipment.
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\CompaniesHouse")
     * @ORM\JoinColumn(name="company_house_id", referencedColumnName="id")
     */
    private $companyHouse;

    /**
     * @ORM\Column(name="guid", type="string", length=255, nullable=false)
     */
    private $guid  ;

    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ClientContacts", mappedBy="client")
     */
    private $contacts;
    /**
     * One client has Many documents.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ClientDocuments", mappedBy="client")
     */
    private $documents;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param mixed $id
     * @return Client
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
     * @return Client
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
     * @return Client
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     * @return Client
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     * @return Client
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return Client
     */
    public function setUrl($url)
    {
        $this->url = $url;
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
     * @return Client
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * @param mixed $guid
     * @return Client
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param mixed $contacts
     * @return Client
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
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
     * @return Client
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
     * @return Client
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
     * @return Client
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
     * @return Client
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
     * @return Client
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
     * @return Client
     */
    public function setAddPostcode($addPostcode)
    {
        $this->addPostcode = $addPostcode;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param mixed $documents
     * @return Client
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
        return $this;
    }

    /**
     * @return mixed
     */
    public function _toArray()
    {
        if ($this->getCompany()){
            $name = $this->getCompany();
        }else{
            $name = $this->getFirstname().' '.$this->getSurname();
        }
        $array=[
            'id'=>$this->getId(),
            'name'=>$name,
        ];
        return $array;
    }

    /**
     * @return mixed
     */
    public function displayName()
    {
        if ($this->getCompany()){
            $name = $this->getCompany();
        }else{
            $name = $this->getFirstname().' '.$this->getSurname();
        }
        return $name;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return Client
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompanyHouse()
    {
        return $this->companyHouse;
    }

    /**
     * @param mixed $companyHouse
     * @return Client
     */
    public function setCompanyHouse($companyHouse)
    {
        $this->companyHouse = $companyHouse;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getClientType()
    {
        return $this->clientType;
    }

    /**
     * @param mixed $clientType
     * @return Client
     */
    public function setClientType($clientType)
    {
        $this->clientType = $clientType;
        return $this;
    }


}