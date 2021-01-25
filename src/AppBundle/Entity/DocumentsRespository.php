<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class DocumentsRespository extends EntityRepository
{
    public function checkDocumentExists(Documents $data)
    {
        $em = $this->getEntityManager();
        $error = null;
        $exists = $em->getRepository('AppBundle:Documents')->findOneBy(['document'=>$data->getDocumentName()]);
        if (!empty($exists)){
            $error='A document with that name already exists.';
        }
        return $error;
    }

    public function saveDocument(Documents $docEntity, $file, $docSavePath)
    {
        $em = $this->getEntityManager();
        if (is_null($file)){
            $doc = $docEntity->getDocument();
        }else{
            $mime = explode('/', $file->getMimeType(), 2)[1];
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $docUploadName = $this->tidyDocName($originalFilename);
            $doc = $this->moveSavedDocument($file, $docUploadName,$docSavePath);
            $docEntity->setMimeType($mime);
        }
        $docEntity->setDocument($doc);
        $docEntity->setDocumentName($this->tidyDocName($docEntity->getDocumentName()));
        $em->persist($docEntity);
        $em->flush();
    }
    public function tidyDocName ($originalFilename){
        $docUploadName = str_replace(' ', '_', $originalFilename);
        $docUploadName = str_replace('-', '_', $docUploadName);
        $docUploadName = str_replace('\\', '_', $docUploadName);
        $docUploadName = str_replace('/', '_', $docUploadName);
        return $docUploadName;
    }
    public function deleteDocument(Documents $doc)
    {
        $em = $this->getEntityManager();
        $doc->setDeleted(true);
        $em->persist($doc);
        $em->flush();
    }

    public function moveSavedDocument ($file, $name,$docSavePath){
        if ($file) {
            $newFilename = $name.'.'.$file->guessExtension();
            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $docSavePath,
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            return $newFilename;
        }
    }

}