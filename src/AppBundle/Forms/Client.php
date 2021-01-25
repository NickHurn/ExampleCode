<?php
namespace AppBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class Client extends AbstractType
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
            ->add('clientType', ChoiceType::class, [
                'attr' => ['class' => 'form-control clientType',],
                'required'	=> true,
                'choices'  => [
                    'Individual '=>'i',
                    'Company '=>'c',
                ],
                'placeholder'=>'Please Select',
                'label' => 'Client Type ',
                'label_attr' => ['class'=> 'col-sm-3'],
                'expanded'=>false,
                'multiple'=>false,
            ])
            ->add('firstname', TextType::class,[
                'constraints'=>[new Length(array('min'=>3))],
                'required'	=> true,
                'attr' => ['class' => 'form-control',  'placeholder' => 'Firstname'],
                'label' => 'Firstname',
                'label_attr' => ['class'=> 'col-sm-3'],
            ])
            ->add('surname', TextType::class,[
                'constraints'=>[new Length(array('min'=>3))],
                'required'	=> true,
                'attr' => ['class' => 'form-control','placeholder' => 'Surname'],
                'label' => 'Surname',
                'label_attr' => ['class'=> 'col-sm-3'],
            ])
            ->add('company', TextType::class,[
                'constraints'=>[new Length(array('min'=>3))],
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Company Name'],
                'label' => 'Company Name',
                'label_attr' => ['class'=> 'col-sm-3'],
            ])
            ->add('image', FileType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control',  'placeholder' => 'Logo'],
                'label'=>'Logo',
                'label_attr' => ['class'=>'col-sm-3 control-label'],
                'mapped' => false,
                'data_class' => null,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid jpg or png image',
                    ])
                ]])
            ->add('url', TextType::class,[
                'constraints'=>[new Length(array('min'=>3))],
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'URL'],
                'label' => 'URL',
                'label_attr' => ['class'=> 'col-sm-3'],
            ])
            ->add('addLine1', TextType::class,[
                'required'	=> true,
                'attr' => ['class' => 'form-control','placeholder' => 'Address Line 1'],
                'label'=>'Address Line 1',
                'label_attr' => ['class'=>'col-sm-3 control-label'],
            ])
            ->add('addLine2', TextType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Address Line 2'],
                'label'=>'Address Line 2',
                'label_attr' => ['class'=>'col-sm-3 control-label'],
            ])
            ->add('addLine3', TextType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Address Line 3'],
                'label'=>'Address Line 3',
                'label_attr' => ['class'=>'col-sm-3 control-label'],
            ])
            ->add('addTown', TextType::class,[
                'required'	=> true,
                'attr' => ['class' => 'form-control','placeholder' => 'Town'],
                'label'=>'Town',
                'label_attr' => ['class'=>'col-sm-3 control-label'],
            ])
            ->add('addCounty', TextType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'County'],
                'label'=>'County',
                'label_attr' => ['class'=>'col-sm-3 control-label'],
            ])
            ->add('addPostcode', TextType::class,[
                'required'	=> true,
                'attr' => ['class' => 'form-control','placeholder' => 'Post Code'],
                'label'=>'Post Code',
                'label_attr' => ['class'=>'col-sm-3 control-label'],
            ])

            ->add('save', SubmitType::class,[
                'attr' => ['class' => 'btn btn-info btn-md ', 'value'=>'save'],'label'=>'Save',])
            ->add('remove', SubmitType::class,[
                'attr' => ['class' => 'btn btn-info btn-md ', 'value'=>'remove'],'label'=>'Remove',])



        ;
    }
}