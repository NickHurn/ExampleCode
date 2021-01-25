<?php
namespace AppBundle\Form;



use AppBundle\Entity\ClientDocuments;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;


class ClientInvoiceForm extends AbstractType
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

            ->add('description', TextType::class,[
                'constraints'=>[new Length(array('min'=>3, 'max'=>100))],
                'required'	=> true,
                'attr' => ['class' => 'form-control','placeholder' => 'Invoice Description'],
                'label'=>'Invoice Description',
            ])
            ->add('days', NumberType::class,[
                'required'	=> true,
                'attr' => ['class' => 'form-control','placeholder' => 'Quantity / Days'],
                'label'=>'Quantity / Days',
                'scale'=>2,
            ])
            ->add('dayRate', MoneyType::class,[
                'required'	=> true,
                'attr' => ['class' => 'form-control','placeholder' => 'Unit Price'],
                'label'=>'Unit Price',
                'scale'=>2,
                'currency'=>'',
            ])
            ->add('description2', TextType::class,[
                'constraints'=>[new Length(array('min'=>3, 'max'=>100))],
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Invoice Description'],
                'label'=>'Invoice Description',
            ])
            ->add('days2', NumberType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Quantity / Days'],
                'label'=>'Quantity / Days',
                'scale'=>2,
            ])
            ->add('dayRate2', MoneyType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Unit Price'],
                'label'=>'Unit Price',
                'scale'=>2,
                'currency'=>'',
            ])
            ->add('description3', TextType::class,[
                'constraints'=>[new Length(array('min'=>3, 'max'=>100))],
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Invoice Description'],
                'label'=>'Invoice Description',
            ])
            ->add('days3', NumberType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Quantity / Days'],
                'label'=>'Quantity / Days',
                'scale'=>2,
            ])
            ->add('dayRate3', MoneyType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Unit Price'],
                'label'=>'Unit Price',
                'scale'=>2,
                'currency'=>'',
            ])
            ->add('description4', TextType::class,[
                'constraints'=>[new Length(array('min'=>3, 'max'=>100))],
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Invoice Description'],
                'label'=>'Invoice Description',
            ])
            ->add('days4', NumberType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Quantity / Days'],
                'label'=>'Quantity / Days',
                'scale'=>2,
            ])
            ->add('dayRate4', MoneyType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Unit Price'],
                'label'=>'Unit Price',
                'scale'=>2,
                'currency'=>'',
            ])
            ->add('description5', TextType::class,[
                'constraints'=>[new Length(array('min'=>3, 'max'=>100))],
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Invoice Description'],
                'label'=>'Invoice Description',
            ])
            ->add('days5', NumberType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Quantity / Days'],
                'label'=>'Quantity / Days',
                'scale'=>2,
            ])
            ->add('vatRate', NumberType::class,[
                'required'	=> true,
                'attr' => ['class' => 'form-control','placeholder' => 'VAT Rate %'],
                'label'=>'VAT Rate %',
                'scale'=>2,
            ])->add('vat', CheckboxType::class, [
                'label'    => 'VAT applicable',
                'required' => false,
            ])
            ->add('dayRate5', MoneyType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Unit Price'],
                'label'=>'Unit Price',
                'scale'=>2,
                'currency'=>'',
            ])
            ->add('discount', MoneyType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Discount'],
                'label'=>'Discount',
                'currency'=>'',
                'scale'=>2,
            ])

            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-info btn-md '],
                'label'=>'Save'
            ])

        ;
    }
}