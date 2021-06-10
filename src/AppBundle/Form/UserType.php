<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use \Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('usernick', TextType::class, array('label'=>'Nick:','required'=>'required','attr'=>array('class'=>'form-nick form-control')))
                ->add('name', TextType::class, array('label'=>'Nombre:','required'=>'required','attr'=>array('class'=>'form-name form-control')))
                ->add('surname', TextType::class, array('label'=>'Apellidos:','required'=>'required','attr'=>array('class'=>'form-surname form-control')))
                ->add('maildir', EmailType::class, array('label'=>'Correo electrónico:','required'=>'required','attr'=>array('class'=>'form-mail form-control mail-input')))
                ->add('biography', TextareaType::class, array('label'=>'¡Cuenta algo sobre ti!','required'=> false,'attr'=>array('class'=>'form-bio form-control')))
                ->add('userimage', FileType::class, array('label'=>'Imagen de perfil','required'=> false,'data_class'=>null,'attr'=>array('class'=>'form-image form-control')))

                ->add('Guardar', SubmitType::class, array('label' => 'Guardar', "attr" => array("class" => "form-submit-guardar col-lg-3 btn btn-success")))
        ;
                
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backendbundle_user';
    }


}
