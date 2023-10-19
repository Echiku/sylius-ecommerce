<?php

namespace App\Form;

use App\Entity\Produit;
use App\Form\ImageProduitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('description',TextType::class)
            ->add('prix',NumberType::class)
            ->add('categorie',TextType::class)
            ->add('image', CollectionType::class, [
                'entry_type' => ImageProduitType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
