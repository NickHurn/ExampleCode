<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class SearchForm extends AbstractType
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
            ->add('searchTerm', TextType::class,[
                'required'	=> false,
                'attr' => ['class' => 'form-control','placeholder' => 'Please enter the search term'],
                'label'=>'Search For:',
                'label_attr' => ['class'=> 'col-sm-2'],
                ])
            ->add('search', SubmitType::class,[
                'attr' => ['class' => 'btn btn-info btn-md btn-block'],
                'label'=>'Search'
            ]);
    }
}