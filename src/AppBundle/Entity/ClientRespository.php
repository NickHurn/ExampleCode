<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class ClientRespository extends EntityRepository
{
    public function findClientsLike($searchterm)
    {
        $em = $this->getEntityManager();
        $repository = $em->getRepository('AppBundle:Client');
        $query = $repository->createQueryBuilder('i')
            ->where('i.firstname LIKE :searchTerm')
            ->orWhere('i.surname LIKE :searchTerm')
            ->orWhere('i.company LIKE :searchTerm')
            ->andWhere('i.active = :active')
            ->orderBy('i.surname','ASC')
            ->addOrderBy('i.company', 'ASC')
            ->setParameter('searchTerm', '%'.$searchterm['searchTerm'].'%')
            ->setParameter('active', 1)
            ->getQuery();
        $result = $query->getResult();
        return $result;
    }

    public function getGuid($data)
    {
        $currentDateTime = time();
        $uniqueId = md5($data['firstname'] . $data['surname'] . $currentDateTime);
        return $uniqueId;
    }

    public function saveClient($data, Client $newClient, CompaniesHouse $ch)
    {
        $em = $this->getEntityManager();

        $guid = $this->getGuid($data->get('client'));
        //save client
        $newClient->setGuid($guid);
        $newClient->setCompanyHouse($ch);
        $newClient->setAddLine1($data->get('addLine1'));
        $newClient->setAddLine2($data->get('addLine2'));
        $newClient->setAddLine3($data->get('addLine3'));
        $newClient->setAddTown($data->get('addTown'));
        $newClient->setAddCounty($data->get('addCounty'));
        $newClient->setAddPostcode($data->get('addPostcode'));
        $em->persist($newClient);
        $em->flush();
        return $newClient;
    }


    public function updateCompanyHouseDetails ($data, Client $client)
    {
        $em = $this->getEntityManager();
        $x = $em->getRepository('AppBundle:CompaniesHouse')->findOneBy(['companyNumber'=>$data->company_number]);
        dump    ($data, $client, $x);exit;

    }

    public function addCompanyHouseDetailsToClient (Client $client, CompaniesHouse $ch)
    {
        $em = $this->getEntityManager();
        $client->setCompanyHouse($ch);
        $em->persist($client);
        $em->flush();

    }

}