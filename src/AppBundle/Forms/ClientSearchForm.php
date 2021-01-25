<?php
namespace AppBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientSearchForm extends AbstractType
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
            ->add('client', EntityType::class,[
                'required'	=> true,
                'attr' => ['class' => 'form-control clientSelect'],
                'class' => 'AppBundle\Entity\Client',
                'choice_label' => function($client){
                    return $client->displayName();
                },
                'choice_value'=> 'id',
                'placeholder' => 'Please Select',
                'label' => 'Client',
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-info btn-md submitRequest ', ],
                'label'=>'Select'
            ])

        ;
    }
}