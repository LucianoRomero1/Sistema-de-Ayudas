<?php

namespace App\Form;

use App\Entity\PerfilSolicitante;
use App\Entity\TitulosInicio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PerfilSolicitanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion_corta')
            ->add('descripcion_larga', TextareaType::class)
            ->add('comunidad_unraf', ChoiceType::class, [
                'choices'  => [
                    'Pertenece a la Comunidad UNRAf' => 'Pertenece',
                    'No pertenece a la Comunidad UNRAf' => 'No Pertenece',
                ],
            ])
           
            // ->add('publicado', ChoiceType::class, [
            //     'choices'  => [
            //         'Publicado' => 'Publicado',
            //         'Despublicado' => 'Despublicado',
            //     ],
            // ])
            ->add('icono', FileType::class, ['data_class' => null,'required'=>false,'multiple'=>false]) 
            ->add('fecha_publicacion_desde', DateType::class, ['widget' => 'single_text', 'required' => false])
            ->add('fecha_publicacion_hasta', DateType::class, ['widget' => 'single_text', 'required' => false])
            ->add('Aceptar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PerfilSolicitante::class,
        ]);
    }
}
