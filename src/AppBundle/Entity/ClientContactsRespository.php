<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class ClientContactsRespository extends EntityRepository
{
    public function checkClientContact($data)
    {

        $em = $this->getEntityManager();
        $clientError = null;
        $clientExists = $em->getRepository('AppBundle:ClientContacts')->findBy(['firstname'=>$data['firstname'], 'surname'=>$data['surname'],'active'=>1]);
        if (!empty($clientExists)){
            $clientError='A contact with that name already exists.';
        }
        return $clientError;
    }

    public function saveClientContact($data, Client $client)
    {
        $em = $this->getEntityManager();
        $contact = new ClientContacts();
        $contact->setFirstname($client->getFirstname());
        $contact->setSurname($client->getSurname());
        $contact->setContactNo($data->get('contactNumber'));
        $contact->setMobileNo($data->get('mobileNumber'));
        $contact->setEmail($data->get('email'));
        $contact->setJobTitle($data->get('jobTitle'));
        $contact->setLinkedin($data->get('linkedIn'));
        $contact->setSkype($data->get('skype'));
        $contact->setClient($client);
        $em->persist($contact);
        $em->flush();
    }

    public function deleteClientContact($cc)
    {
        $em = $this->getEntityManager();
        $cc->setActive(0);
        $em->persist($cc);
        $em->flush();
    }
}