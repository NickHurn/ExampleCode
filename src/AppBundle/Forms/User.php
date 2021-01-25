<?php
namespace AppBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class User extends AbstractType
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
            ->add('firstname', TextType::class,[
                'constraints'=>[new Length(array('min'=>3))],
                'required'	=> true,
                'attr' => ['class' => 'form-control',  'placeholder' => 'Firstname']])
            ->add('surname', TextType::class,[
                'constraints'=>[new Length(array('min'=>3))],
                'required'	=> true,
                'attr' => ['class' => 'form-control','placeholder' => 'Surname']])
            ->add('username', EmailType::class,[
                'constraints'=>[new Length(array('min'=>7))],
                'required'	=> true,
                'attr' => ['class' => 'form-control','placeholder' => 'Email'],
                'label'=>'Email'])
            ->add('roles', EntityType::class,[
                'required'	=> true,
                'attr' => ['class' => ''],
                'class' => 'AppBundle\Entity\Role',
                'choice_label' => 'friendlyName',
                'choice_value'=> 'id',
                'expanded'=>true,
                'multiple'=>true,
            ])
            ->add('save', SubmitType::class,[
                'attr' => ['class' => 'btn btn-info btn-md ', 'value'=>'save'],'label'=>'Save',])
            ->add('remove', SubmitType::class,[
                'attr' => ['class' => 'btn btn-info btn-md ', 'value'=>'remove'],'label'=>'Remove',])



        ;
    }
}