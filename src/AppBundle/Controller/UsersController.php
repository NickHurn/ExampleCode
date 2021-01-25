<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\IsTrue;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UsersController extends Controller
{
    /**
     * @Route("/newuserdetails", name="new_user_details")
     */
    public function NewUserDetailsAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = NULL;
        $title ='Add New User';
        $newUser=new User();

        $userForm = $this->createForm(\AppBundle\Form\User::class);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted()) {
            if ($userForm->isValid()) {
                $data=$request->request;
                $userExists= $em->getRepository('AppBundle:User')->findOneBy(['username'=>$data->get('user')['username']]);
                if ($userExists != null){
                    $errorMessage = 'Sorry that users already exists';
                }else{
                    $encoder = $this->get('security.password_encoder');
                    $password = $em->getRepository('AppBundle:User')->getPassword($data->get('user'));
                    $encoded = $encoder->encodePassword($newUser, $password);
                    $guid = $em->getRepository('AppBundle:User')->getGuid($data->get('user'));
                    $role = $em->getRepository('AppBundle:Role')->findOneBy(['friendlyName'=>'admin']);
                    $savedUser = $em->getRepository('AppBundle:User')->saveUser($data->get('user'), $newUser, $encoded, $guid, $role);

                    $url = $this->getParameter('domain').'/login';
                    $companyDetails = $em->getRepository('AppBundle:CompanyDetails')->find(1);
                    $mail = \Swift_Message::newInstance()
                        ->setSubject('Welcome')
                        ->setFrom($this->getParameter('new_user_email'))
                        ->setTo($savedUser->getUsername())
                        ->setBody(
                            $body = $this->renderView('templates/newUser.html.twig',
                                array('name' => $savedUser->getFirstname().' '.$savedUser->getSurname(), 'password' => $password, 'url' => $url, 'companyDetails'=>$companyDetails)
                            ),
                            'text/html'
                        )
                        ->addPart(
                            $body = $this->renderView('templates/newUser.html.twig',
                                array('name' => $savedUser->getFirstname().' '.$savedUser->getSurname(), 'password' => $password, 'url' => $url, 'companyDetails'=>$companyDetails)
                            ),
                            'text/plain'
                        );
                    $this->get('mailer')->send($mail);
                    $message ='User Added.  An email has been sent to them with a temporary password';
                }
            }
        }
        return $this->render('user/newuser.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'userForm' => $userForm->createView(),
            'title'=>$title,
        ]);

    }

    /**
     * @Route("/users/findusers", name="find_users")
     */
    public function FindUsersDetailsAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = NULL;
        $title = 'Find Users';
        $users = $em->getRepository('AppBundle:User')->findBy(['active'=>1]);
        return $this->render('user/finduser.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'users' => $users,
            'title'=>$title,
        ]);
    }

    /**
     * @Route("/users/user/{guid}", name="user")
     */
    public function UsersDetailsAction(Request $request, $guid=null)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $message ='';
        $errorMessage = NULL;
        $title = 'User';
        if (is_null($guid)){
            $user = new User();
        }else {
            $user = $em->getRepository('AppBundle:User')->findOneBy(['guid' => $guid]);
        }

        $userForm = $this->createForm(\AppBundle\Form\User::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted()) {
            if ($userForm->isValid()) {
                if ($userForm->getClickedButton() && 'save' === $userForm->getClickedButton()->getName()) {
                    $em->persist($user);
                    $em->flush();
                }
                if ($userForm->getClickedButton() && 'remove' === $userForm->getClickedButton()->getName()) {
                    $user->setActive(0);
                    $em->persist($user);
                    $em->flush();
                }
               $message = 'User '.$user->getFirstname().' '.$user->getSurname().' has been saved.';
            }
        }

        return $this->render('user/user.html.twig', [
            'message'=>$message,
            'errorMessage'=>$errorMessage,
            'user' => $user,
            'title'=>$title,
            'form' => $userForm->createView(),
        ]);

    }

}