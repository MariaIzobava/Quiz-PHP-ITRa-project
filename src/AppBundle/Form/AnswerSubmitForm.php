<?php

namespace AppBundle\Form;
use AppBundle\Entity\Question;
use AppBundle\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerSubmitForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $arr = $options['user_question_data'];
        
        $q = $options['questions'];
   
        $num = $arr['question'];
        $ans = array(
            $q[$num]['variant1'],
            $q[$num]['variant2'],
            $q[$num]['variant3'],
        );
        
        $number = $num + 1;
        
        $builder
            ->add('text', TextareaType::class, array(
                'label' => "Question №$number",
                'data' => $q[$num]['text'],
                'disabled' => true, 
                ))
                
            ->add('answers', ChoiceType::class, array (
                'choices' => $ans,
                'choice_label' => function ($value, $key, $index) {
                            return $value;
                            },                     
                ))
            
            ->add('submit', SubmitType::class, array('label' => 'answer'))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
            'user_question_data' => null, 
            'questions' => null,
        ));
    }
}

