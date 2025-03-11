<?php

namespace App\Form;

use App\Entity\Account;
use App\Entity\Article;
use App\Entity\Category;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Titre de l\'article'
            ],[
                'attr' =>[
                    'placeholder' => 'saisir le titre de l\article'   
                ]
            ])
            ->add('content', TextareaType::class,[
                'label' => 'Contenu de l\'article'
            ],[
                'attr' =>[
                    'placeholder' => 'saisir le titre de l\article'   
                ]
            ])
            ->add('createAt', DateTimeType::class,[
                'label' => 'Date de création de l\'article'
            ],[
                'attr' =>[
                    'placeholder' => 'saisir le titre de l\article'   
                ]
            ])
            ->add('author', TextType::class,[
                'label' => 'Auteur de l\'article'
            ],[
                'attr' =>[
                    'placeholder' => 'saisir le titre de l\article'   
                ]
            ])
            ->add('categories', TextType::class,[
                'label' => 'Catégorie de l\'article'
            ],[
                'attr' =>[
                    'placeholder' => 'saisir le titre de l\article'   
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
