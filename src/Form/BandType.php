<?php

namespace App\Form;

use App\Entity\Artists;
use App\Entity\Band;
use App\Entity\Concert;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('members', EntityType::class, [
                'class' => Artists::class,
                'multiple' => true,
                'choice_label' => 'scene_name'
            ])
            ->add('concerts', EntityType::class, [
                'class' => Concert::class,
                'multiple' => true,
                'choice_label' => 'tour_name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
        ]);
    }
}
