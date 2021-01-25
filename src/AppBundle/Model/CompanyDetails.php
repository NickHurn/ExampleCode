<?php
namespace AppBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CompanyDetails extends Controller
{
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }


    public function companyDetails()
    {

        $companyDetails = $this->em->getRepository('AppBundle:CompanyDetails')->find(1);

        if(is_null($companyDetails)){
            throw new \Exception('Invalid footer');
        }

        return $companyDetails;
    }


    public function whiteLabel()
    {
        $url = $_SERVER['HTTP_HOST'] ;
        if (is_null($url)){
            $url =  $_SERVER['SERVER_NAME'];
        }
        $parse = parse_url($url);
        $domain = str_replace('www.','',$parse['path']);

        $whiteLabel = $this->em->getRepository('AppBundle:WhiteLabel')->findOneBy(['domain'=>$domain]);

        return $whiteLabel;
    }
}