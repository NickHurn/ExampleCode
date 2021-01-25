<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use http\Params;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InvoiceSettingsRepository extends EntityRepository
{

    public function saveDocument(InvoiceSettings $invoiceSettings, $request, $imagesPath)
    {
        $em = $this->getEntityManager();

        if (!is_null($request->files->get('invoice_settings_form')['invoiceLogo'])){
            $uploadedDoc = $request->files->get('invoice_settings_form')['invoiceLogo'];
            $docName = 'invoiceLogo';
            $newFilename = $this->saveImage($uploadedDoc, $docName, $imagesPath);
            $invoiceSettings->setInvoiceLogo($newFilename);
        }
        $em->persist($invoiceSettings);
        $em->flush();
    }

    public function saveImage ($uploadedDoc, $name, $filePath){
        if ($uploadedDoc) {
            $newFilename = $name.'.'.$uploadedDoc->guessExtension();
            // Move the file to the directory where brochures are stored
            try {
                $uploadedDoc->move(
                   $filePath,
                   $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            return $newFilename;
        }
    }

}
