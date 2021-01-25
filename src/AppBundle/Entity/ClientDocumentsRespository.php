<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class ClientDocumentsRespository extends EntityRepository
{
    public function checkDocumentExists($data)
    {

        $em = $this->getEntityManager();
        $error = null;
        $exists = $em->getRepository('AppBundle:ClientDocuments')->findBy(['documentName'=>$data['documentName']]);
        if (!empty($exists)){
            $error='A document with that name already exists.';
        }
        return $error;
    }

    public function saveDocument(ClientDocuments $docEntity,$file, Client $client, $docSavePath)
    {
        $em = $this->getEntityManager();
        $mime = explode('/', $file->getMimeType(), 2)[1];
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $docUploadName = $this->tidyDocName($originalFilename);
        $newFilename = $this->moveSavedDocument($file, $docUploadName,$docSavePath);
        $docEntity->setClient($client);
        $docEntity->setMimeType($mime);
        $docEntity->setDocumentName($newFilename);
        $docEntity->setDocument($newFilename.$mime);
        $em->persist($docEntity);
        $em->flush();
    }
    public function tidyDocName ($originalFilename)
    {
        $docUploadName = str_replace(' ', '_', $originalFilename);
        $docUploadName = str_replace('-', '_', $docUploadName);
        $docUploadName = str_replace('\\', '_', $docUploadName);
        $docUploadName = str_replace('/', '_', $docUploadName);
        return $docUploadName;
    }


    public function deleteDocument(ClientDocuments $doc)
    {
        $em = $this->getEntityManager();
        $doc->setDeleted(true);
        $em->persist($doc);
        $em->flush();
    }

    public function moveSavedDocument ($form, $name,$docSavePath)
    {
        if ($form) {
            $newFilename = $name.'.'.$form->guessExtension();
            // Move the file to the directory where daocs are stored
            try {
                $form->move(
                    $docSavePath,
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            return $newFilename;
        }
    }

    public function copyDocTemplateAndSave($newfile, Documents $oldDoc,  $docSavePath, $client)
    {
        $em = $this->getEntityManager();
        $newfile = $this->tidyDocName($newfile);
        $doc = new ClientDocuments();
        $doc->setClient($client);
        $doc->setDocumentName($newfile);
        $doc->setDocument($oldDoc->getDocument());
        $doc->setVersion($oldDoc->getVersion());
        $doc->setMimeType($oldDoc->getMimeType());
        $doc->setDescription($oldDoc->getDescription());
        $em->persist($doc);
        $em->flush();
        if (!copy($docSavePath.$oldDoc->getDocument(), $docSavePath.$newfile)) {
            echo "failed to copy";
        }
    }

}