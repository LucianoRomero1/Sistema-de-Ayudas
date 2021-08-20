<?php

namespace App\Form;

use App\Entity\Contacto;
use App\Entity\CategoriaPrincipal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('categoriaPrincipal', EntityType::class, [
            'class' => CategoriaPrincipal::class,
            'choice_label' => 'nombre_categoria',
        ])
        ->add('email', EmailType::class)
        ->add('Aceptar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contacto::class,
            
        ]);
    }
}
