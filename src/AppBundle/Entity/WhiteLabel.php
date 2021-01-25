<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Table(name="white_label")
 * @ORM\Entity()

 */
class WhiteLabel
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
     * One white label has One company details.
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\CompanyDetails")
     * @ORM\JoinColumn(name="company_details_id", referencedColumnName="id")
     */
    private $companyDetails;
    /**
     * @ORM\Column(name="date_added", type="datetime",)
     */
    private $dateAdded  ;
    /**
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
    private $domain  ;

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
    public function getCompanyDetails()
    {
        return $this->companyDetails;
    }

    /**
     * @param mixed $companyDetails
     * @return Client
     */
    public function setCompanyDetails($companyDetails)
    {
        $this->companyDetails = $companyDetails;
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
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param mixed $domain
     * @return Client
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }



}