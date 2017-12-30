<?php

namespace AppBundle\Form;
use AppBundle\Entity\Question;
use AppBundle\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class QuizForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $arr = $options['questions'];
        $builder
            ->add('name', TextType::class, array('label' => 'Name of quiz'))
            ->add('questions', ChoiceType::class, array (
                'choices' => $arr,
                'choice_label' => function ($value, $key, $index) {
                            return $value->__toString();
                            },
                'multiple' => true, 
            )
                   
            )
            ->add('flag_active', CheckboxType::class, array(
                'label' => 'Active',
                'attr' => array('checked' => 'checked')
            ))
            ->add('save', SubmitType::class, array('label' => 'Create new Quiz'))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Quiz::class,
            'questions' => null, 
        ));
    }
}

