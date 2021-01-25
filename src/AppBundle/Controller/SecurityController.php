<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Form\ForgotPassword;
use AppBundle\Form\Login;
use AppBundle\Form\NewPassword;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function LoginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one

        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/login_success", name="login_success")
     */
    public function postLoginRedirectAction()
    {
        $user = $this->getUser();

        if ($user->getRoles()[0] == 'ROLE_ADMIN'){
            $model = $this->get('app.company_setup');
            $results = $model->companyDetailsCheck();
            if ($results === true){
                return $this->redirectToRoute("company_setup");
            }else {
                return $this->redirectToRoute("dashboard");
            }
        }
        if ($user->getRoles()[0] == 'ROLE_CLIENT'){
            return $this->redirectToRoute('client_dashboard');
        }


    }

    /**
     * @Route("/newpassword", name="home_change_password")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function setPasswordAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $title = 'Set Password';
        $newPassword = $this->createForm(NewPassword::class);
        $newPassword->handleRequest($request);
        if($newPassword->isSubmitted() && $newPassword->isValid())
        {
            $userDetails=$this->getUser();
            $data = $newPassword->getData();
            $user=$em->getRepository('AppBundle:User')->find($userDetails->getId());
            $encoder = $this->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $data['password']);
            $user->setPassword($encoded);
            $user->setTempPassword(0);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login_success');

        }

        return $this->render('security/newpassword.html.twig', [
            'form' => $newPassword->createView(),
            'title'=>$title,
        ]);
    }

    /**
     * @Route("/forgotpassword", name="forgotpassword")
     */
    public function ForgotPasswordAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $message = null;
        $forgotPasswordForm = $this->createForm(ForgotPassword::class);
        $forgotPasswordForm->handleRequest($request);
        $companyDetails = $em->getRepository('AppBundle:CompanyDetails')->find(1);

        if($forgotPasswordForm->isSubmitted() && $forgotPasswordForm->isValid()) {
            $data = $forgotPasswordForm->getData();
            $user = $em->getRepository('AppBundle:User')->findOneBy(['username'=>$data]);
            $password = substr(base64_encode(random_bytes(8)), 0, -1);
            $encoder = $this->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $password);
            $user->setTempPassword(1);
            $user->setPassword($encoded);
            $em->persist($user);
            $em->flush();
            $url = $this->getParameter('domain').'/login';


            $message = \Swift_Message::newInstance()
                ->setSubject('Password Reset')
                ->setFrom($this->getParameter('new_user_email'))
                ->setTo($user->getUsername())
                ->setBody(
                    $this->renderView('templates/forgotPassword.html.twig',
                        array('name' => $user->getFirstname().' '.$user->getSurname(), 'password' => $password,'url'=>$url, 'companyDetails'=>$companyDetails)
                    ),
                    'text/html'
                )
                ->addPart(
                    $this->renderView('templates/forgotPassword.html.twig',
                        array('name' =>$user->getFirstname().' '.$user->getSurname(), 'password' => $password, 'url'=>$url, 'companyDetails'=>$companyDetails)
                    ),
                    'text/plain'
                );
            $this->get('mailer')->send($message);


            $message =  'An email has been sent to you to reset your password.';
        }

        // replace this example code with whatever you need
        return $this->render('security/forgotpassword.html.twig', [
            'forgotPasswordForm'=> $forgotPasswordForm->createView(),
            'message'=>$message,

        ]);
    }



}
