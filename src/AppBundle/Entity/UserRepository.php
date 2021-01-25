<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use http\Params;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserRepository extends EntityRepository
{
    public function getPassword($data)
    {
        $password = substr(base64_encode(random_bytes(8)), 0, -1);

        return $password;
    }
    public function getGuid($data)
    {
        $currentDateTime = time();
        $uniqueId = md5($data['firstname'] . $data['surname'] . $currentDateTime);
        return $uniqueId;
    }

    public function saveUser($data, User $newUser, $encoded, $guid, $role, $client)
    {
        $em = $this->getEntityManager();
        $newUser->setGuid($guid);
        $newUser->setPassword($encoded);
        $newUser->setFirstname($data['firstname']);
        $newUser->setSurname($data['surname']);
        $newUser->setUsername($data['username']);
        $newUser->setRoles($role);
        $newUser->setClient($client);
        $em->persist($newUser);
        $em->flush();
        return $newUser;
    }

}
