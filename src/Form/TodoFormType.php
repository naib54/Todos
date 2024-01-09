<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Tasks;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class TodoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('Description')
            ->add('Duedate')
            ->add('Priority')
            ->add('Category', EntityType::class, [
                'class' => Categories::class,
'choice_label' => 'id',
            ])
            ->add('save', SubmitType::class);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tasks::class,
        ]);
    }
    
}
