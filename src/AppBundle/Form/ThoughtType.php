<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ThoughtType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('text', TextareaType::class, array('label' => 'Escribe el texto que quieras incluir en tu Thought', 'required' => 'required', 'attr' => array('onpaste' => 'contarcaracteres();', 'onkeyup' => 'check_val();contarcaracteres();', 'class' => 'entrada-texto form-control')))
                ->add('videoyt', TextType::class, array('label' => 'Video de YouTube', 'required' => false, 'data_class' => null, 'attr' => array('class' => 'youtube-home form-control')))
                ->add('image', FileType::class, array('label' => 'Imagen, gif o mp4 (max:128Mb)', 'required' => false, 'data_class' => null, 'attr' => array('class' => 'foto-home form-control')))
                ->add('attachment', FileType::class, array('label' => 'Añadir adjunto (max:128Mb)', 'required' => false, 'data_class' => null, 'attr' => array('class' => 'documento-home form-control')))
                ->add('postear', SubmitType::class, array('label' => 'Postear', "attr" => array('class' => 'boton-thought col-lg-4 btn btn-success')))
        ;
    }

/**
     * {@inheritdoc}
     */

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Thought'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'backendbundle_user';
    }

}
