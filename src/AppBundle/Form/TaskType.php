<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // J'ai généré directement mon formulaire, puis je l'ai indenté et définit des "type" en fonction des propriétés

        $builder
            ->add('title')
            ->add('description', TextareaType::class, array(
                'attr' => array(
                    'cols' => 90, 'rows' => 10
                ), 'label' => 'contenu '
            ))
            ->add('status', ChoiceType::class, array(
                'choices'  => array(
                    'Fait !' => true,
                    'A faire !' => false,
                )))
            ->add('dateCreated', DateType::class, array(
                'widget' => 'single_text',
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Task'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_task';
    }


}
