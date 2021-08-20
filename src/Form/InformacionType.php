<?php

namespace App\Form;

use App\Entity\CategoriaSecundaria;
use App\Entity\Informacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;



class InformacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion_corta')
            // ->add('catSecundaria', EntityType::class, [
            //     'class' => CategoriaSecundaria::class,
            //     'choice_label' => 'nombre_categoria',
            // ])
            ->add('id_categoria_secundaria', EntityType::class, [
                'class' => CategoriaSecundaria::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('cs')
                        ->add('where', "cs.infoAsignada = false");
                
                    },
                'choice_label' => 'nombre_categoria'])
            ->add('explicacion',CKEditorType::class, [
                'empty_data' => ''
            ])
            ->add('Aceptar', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Informacion::class,
        ]);
    }
}
