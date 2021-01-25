<?php
namespace AppBundle\Form;



use AppBundle\Entity\ClientDocuments;

use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;


class CompanyDetailsForm extends AbstractType
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

            ->add('logo', FileType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control',  'placeholder' => 'Logo'],
                'label'=>'Logo: ',
                'mapped' => false,
                'data_class' => null,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid jpg, png image',
                    ])
                ]])
            ->add('coName', TextType::class,[
                'required'	=> true,
                'attr' => ['class' => 'form-control','placeholder' => 'Company Name'],
                'label'=>'Company Name',
            ])
            ->add('addLine1', TextType::class,[
                'required'	=> true,
                'attr' => ['class' => 'form-control','placeholder' => 'Address Line 1'],
                'label'=>'Address Line 1',
            ])
            ->add('addLine2', TextType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Address Line 2'],
                'label'=>'Address Line 2',
            ])
            ->add('addLine3', TextType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Address Line 3'],
                'label'=>'Address Line 3',
            ])
            ->add('addTown', TextType::class,[
                'required'	=> true,
                'attr' => ['class' => 'form-control','placeholder' => 'Town'],
                'label'=>'Town',
            ])
            ->add('addCounty', TextType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'County'],
                'label'=>'County',
            ])
            ->add('addPostcode', TextType::class,[
                'required'	=> true,
                'attr' => ['class' => 'form-control','placeholder' => 'Post Code'],
                'label'=>'Post Code',
            ])
            ->add('email', EmailType::class,[
                'required'	=> true,
                'attr' => ['class' => 'form-control contactEmail','placeholder' => 'Email'],
                'label'=>'Email',

            ])
            ->add('contactNo', TextType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control contactContactNo','placeholder' => 'Phone Number'],
                'label'=>'Phone Number',

            ])
            ->add('mobileNo', TextType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control contactContactNo','placeholder' => 'Mobile Number'],
                'label'=>'Mobile Number',

            ])
            ->add('coNumber', TextType::class,[
                'required'	=> true,
                'attr' => ['class' => 'form-control ','placeholder' => 'Company Number'],
                'label'=>'Company Number',

            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-info btn-md '],
                'label'=>'Save'
            ])
        ;
    }
}