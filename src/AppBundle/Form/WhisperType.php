<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class WhisperType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['empty_data'];
        $builder
            ->add('receiver', EntityType::class, array('class'=>'BackendBundle:User',
                'query_builder'=>function($repositorio) use ($user){
                    return $repositorio->getFollowingUsers($user);
                },
                'choice_label' =>function($user){
                    return "#".$user->getUsernick()." ~".$user->getName()." ".$user->getSurname();
                },
                'label' => 'Para:',
                 'attr'=>array('class'=>'form-control')
                
                ))
            ->add('content', TextareaType::class, array('label'=>'Whisper ','required'=>'required','attr'=>array('class'=>'form-control')))

            ->add('image', FileType::class, array('label'=>'Imagen .png, .jpg .jpeg o gif','required'=> false,'data_class'=>null,'attr'=>array('class'=>'foto-whisper form-control')))
            ->add('attachment', FileType::class, array('label'=>'Documento .pdf','required'=> false,'data_class'=>null,'attr'=>array('class'=>'documento-whisper form-control')))

            ->add('enviar', SubmitType::class, array('label' => 'enviar', "attr" => array('class' => 'boton-enviar col-lg-12 btn btn-success')))  
            ;
                
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Whisper'
        ));
    }
}
