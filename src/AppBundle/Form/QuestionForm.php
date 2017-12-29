<?php

// src/AppBundle/Form/UserType.php
namespace AppBundle\Form;

use AppBundle\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuestionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class)
            ->add('variant1', TextType::class)
            ->add('variant2', TextType::class)
            ->add('variant3', TextType::class)
            ->add('answer', ChoiceType::class, array(
                'choices'  => array(
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Question::class,
        ));
    }
}

