<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('email', EmailType::class)
            ->add('tags', EntityType::class, array(
                    'class' => 'AppBundle:Tag',
                    'multiple' => true,
                    'choice_label' => 'name',
                    'expanded' => true
                )
            )
            ->add('category', EntityType::class, array(
                'class' => 'AppBundle:Category',
                'choice_label' => 'name',
            ));
        ;
    }
}
