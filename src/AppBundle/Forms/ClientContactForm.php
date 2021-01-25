<?php
namespace AppBundle\Form;



use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class ClientContactForm extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(

            'csrf_protection' => false,

        ));
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control contactId'],
            ])
            ->add('firstname', TextType::class,[
                'constraints'=>[new Length(array('min'=>3))],
                'required'	=> true,
                'attr' => ['class' => 'form-control contactFirstname',  'placeholder' => 'Firstname'],
                'label'=>'Firstname',
                'label_attr' => ['class'=> 'col-sm-3'],
            ])
            ->add('surname', TextType::class,[
                'required'	=> true,
                'attr' => ['class' => 'form-control contactSurname','placeholder' => 'Surname'],
                'label'=>'Surname',
                'label_attr' => ['class'=> 'col-sm-3'],
            ])
            ->add('jobTitle', TextType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control contactJobTitle','placeholder' => 'Job Title'],
                'label'=>'Job Title',
                'label_attr' => ['class'=> 'col-sm-3'],
            ])
            ->add('skype', TextType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control contactSkype','placeholder' => 'Skype'],
                'label'=>'Skype',
                'label_attr' => ['class'=> 'col-sm-3'],
            ])
            ->add('linkedIn', TextType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control contactLinkedIn','placeholder' => 'linkedIn'],
                'label'=>'linkedIn',
                'label_attr' => ['class'=> 'col-sm-3'],
            ])
            ->add('email', EmailType::class,[
                'required'	=> true,
                'attr' => ['class' => 'form-control contactEmail','placeholder' => 'Email'],
                'label'=>'Email',
                'label_attr' => ['class'=> 'col-sm-3'],
            ])
            ->add('contactNo', TextType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control contactContactNo','placeholder' => 'Phone Number'],
                'label'=>'Phone Number',
                'label_attr' => ['class'=> 'col-sm-3'],
            ])
            ->add('mobileNo', TextType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control contactContactNo','placeholder' => 'Mobile Number'],
                'label'=>'Mobile Number',
                'label_attr' => ['class'=> 'col-sm-3'],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-info btn-md '],
                'label'=>'Save'
            ])
            ->add('remove', SubmitType::class, [
                'attr' => ['class' => 'btn btn-danger btn-md '],
                'label'=>'Delete'
            ])
        ;
    }
}