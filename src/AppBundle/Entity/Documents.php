<?php

// src/AppBundle/Entity/Users.php
namespace AppBundle\Entity;

use AppBundle\Form\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="documents")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DocumentsRespository")

 */
class Documents
{

    public function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->deleted = false;
    }

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(name="deleted", type="boolean", length=255)
     */
    private $deleted;
    /**
     * @ORM\Column(name="document_name", type="string", length=64, nullable=true)
     */
    private $documentName;
    /**
     * @ORM\Column(name="document", type="string", length=64, nullable=false)
     */
    private $document;
    /**
     * @ORM\Column(name="version", type="string", length=64, nullable=true)
     */
    private $version;
    /**
     * @ORM\Column(name="mime_type", type="string", length=64, nullable=false)
     */
    private $mimeType;
    /**
     * @ORM\Column(name="description", type="string", length=64, nullable=true)
     */
    private $description;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false  )
     */
    private $dateCreated;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Documents
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     * @return Documents
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDocumentName()
    {
        return $this->documentName;
    }

    /**
     * @param mixed $documentName
     * @return Documents
     */
    public function setDocumentName($documentName)
    {
        $this->documentName = $documentName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param mixed $document
     * @return Documents
     */
    public function setDocument($document)
    {
        $this->document = $document;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     * @return Documents
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param mixed $mimeType
     * @return Documents
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Documents
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateCreated
     * @return Documents
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }







}