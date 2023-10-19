<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Image;
use App\Repository\ImageProduitRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ImageProduitRepository::class)]
#[ORM\Table(name: 'sylius_image_produit')]
class ImageProduit  extends Image  
{
   

    #[ORM\ManyToOne(inversedBy: 'image',cascade:["persist"])]
    private ?Produit $produit = null;


    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }
    

  
}
