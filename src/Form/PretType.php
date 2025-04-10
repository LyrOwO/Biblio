<?php

namespace App\Form;

use App\Entity\Pret;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PretType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_pret', TextType::class, [
                'label' => 'Nom du prêt',
            ])
            ->add('date_debut_pret', DateTimeType::class, [
                'label' => 'Date de début',
                'widget' => 'single_text',
            ])
            ->add('date_fin_pret', DateTimeType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('books', EntityType::class, [
                'class' => 'App\Entity\Book',
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Livres associés',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pret::class,
        ]);
    }
}
