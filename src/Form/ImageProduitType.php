<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\ImageProduit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Sylius\Bundle\CoreBundle\Form\Type\ImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

final class ImageProduitType extends ImageType 
{
    public function __construct()
    {
        parent::__construct(ImageProduit::class, ['sylius']);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder->remove('type');

       

       
    }

    public function getBlockPrefix(): string
    {
        return 'imageProduit';
    }
}
