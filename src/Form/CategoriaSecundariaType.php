<?php

namespace App\Form;

use App\Entity\CategoriaSecundaria;
use App\Entity\CategoriaPrincipal;
use App\Entity\Destinos;
use App\Entity\PerfilSolicitante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CategoriaSecundariaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('id_categoria_principal', EntityType::class, [
            'class' => CategoriaPrincipal::class,
            'choice_label' => 'nombre_categoria',
        ])
        ->add('nombre_categoria')
        ->add('descripcion_categoria', TextareaType::class)
        // ->add('icono', FileType::class, ['required' => false, 'data_class' => null])
        // ->add('publicado', ChoiceType::class, [
        //     'choices'  => [
        //         'Publicado' => 'Publicado',
        //         'Despublicado' => 'Despublicado',
        //     ],
        // ])
       
        ->add('fecha_publicacion_desde', DateType::class, ['widget' => 'single_text'])
        ->add('fecha_publicacion_hasta', DateType::class, ['widget' => 'single_text' , 'required' => false])
        ->add('perfilAsignado', EntityType::class, [
            'class' => PerfilSolicitante::class,
            'choice_label' => 'descripcion_corta',
        ])
        
           
        ->add('Aceptar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CategoriaSecundaria::class,
        ]);
    }
}
