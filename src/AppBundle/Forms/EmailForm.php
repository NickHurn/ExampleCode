<?php
namespace AppBundle\Form;



use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class EmailForm extends AbstractType
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
            ->add('subject', TextType::class,[
                'constraints'=>[new Length(array('min'=>3))],
                'required'	=> true,
                'attr' => ['class' => 'form-control'],
                'label'=>'Subject',
                'label_attr' => ['class'=> 'col-sm-3'],
            ])
            ->add('body', TextareaType::class,[
                'constraints'=>[new Length(array('min'=>3, 'max'=>100))],
                'required'	=> true,
                'attr' => ['class' => 'form-control','cols' => '5', 'rows' => '5'],
                'label'=>'Email Body',
            ])

            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-info btn-md '],
                'label'=>'Send'
            ])

        ;
    }
}