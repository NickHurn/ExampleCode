<?php
namespace AppBundle\Form;



use AppBundle\Entity\ClientDocuments;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;


class DocumentsForm extends AbstractType
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
            ->add('documentName', TextType::class,[
                'constraints'=>[],
                'required'	=> false,
                'attr' => ['class' => 'form-control',  'placeholder' => 'Document Name'],
                'label' => 'Document Name',
                'label_attr' => ['class'=> 'col-sm-3 font-weight-bold'],
            ])
            ->add('version', TextType::class,[
                'constraints'=>[],
                'required'	=> false,
                'attr' => ['class' => 'form-control',  'placeholder' => 'Version Number'],
                'label' => 'Version Number',
                'label_attr' => ['class'=> 'col-sm-3 font-weight-bold'],
            ])
            ->add('document', FileType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control'],
                'label'=>'Document To Upload',
                'label_attr' => ['class'=> 'col-sm-3 font-weight-bold'],
                'mapped' => false,
                'data_class' => null,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                            'application/pdf'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid jpg, png image or pdf',
                    ])

                ]])
            ->add('description', TextareaType::class,[
                'constraints'=>[new Length(array('min'=>3, 'max'=>100))],
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Document Description','cols' => '5', 'rows' => '5'],
                'label'=>'Document Description',
                'label_attr' => ['class'=> 'font-weight-bold'],
            ])


            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-info btn-md '],
                'label'=>'Save'
            ])

        ;
    }
}