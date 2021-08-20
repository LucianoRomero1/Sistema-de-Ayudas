<?php

namespace App\Form;

use App\Entity\CategoriaPrincipal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class CategoriaPrincipalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre_categoria')
            ->add('descripcion_categoria', TextareaType::class)
            ->add('icono', FileType::class, ['data_class' => null,'required'=>false,'multiple'=>false]) 
            // ->add('publicado', ChoiceType::class, [
            //     'choices'  => [
            //         'Publicado' => 'Publicado',
            //         'Despublicado' => 'Despublicado',
            //     ],
            // ])
            ->add('fecha_publicacion_desde', DateType::class, ['widget' => 'single_text'])
            ->add('fecha_publicacion_hasta', DateType::class, ['widget' => 'single_text' , 'required' => false])
            
            ->add('Aceptar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CategoriaPrincipal::class,
        ]);
    }
}
