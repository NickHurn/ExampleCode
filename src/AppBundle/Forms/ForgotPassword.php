<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class ForgotPassword extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', EmailType::class,[
                'constraints'=>[new Length(array('min'=>7))],
                'required'	=> true,
                'attr' => ['class' => 'form-control','placeholder' => 'Username'],
                'label'=>'Username'])
            ->add('submit', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-info btn-md btn-block'
                ],
                'label'=>'Reset Password'
            ]);
    }
}