<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpFoundation\Response;


class RequestListener
{
    public $em;

    public function __construct($em, TokenStorage $tokenStorage, Router $router, Container $container)
    {
        $this->em = $em;
        $this->tokenstorage = $tokenStorage;
        $this->router = $router;
        $this->container = $container;
    }


    public function onKernelRequest( GetResponseEvent $event )
    {
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }
        if(!is_null($this->tokenstorage->getToken())){
            $user = $this->tokenstorage->getToken()->getUser();
            if($user instanceof User){
                if($user->getTempPassword() == 1 && $this->router->getContext()->getPathInfo() != '/newpassword'){
                    $url = $this->router->generate('home_change_password');
                    $response = new RedirectResponse($url);
                    $event->setResponse($response);
                }
                if($user->getActive() === false && $this->router->getContext()->getPathInfo() != '/login'){
                    $url = $this->router->generate('login');
                    $response = new RedirectResponse($url);
                    $event->setResponse($response);
                }
            }
        }



    }
}