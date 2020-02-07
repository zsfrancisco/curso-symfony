<?php

namespace App\Form;

use App\Entity\Nota;
use App\Entity\Estudiante;
use App\Entity\Asignatura;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NotaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('calificacion')
            ->add('estudiante', EntityType::class,[
                'class' => Estudiante::class,
                'choice_label'=>'nombre'
            ])
            ->add('asignatura', EntityType::class,[
                'class' => Asignatura::class,
                'choice_label'=>'nombre'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Nota::class,
        ]);
    }
}
