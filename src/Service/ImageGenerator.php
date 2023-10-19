<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ImageProduit;
use App\Entity\Produit;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Component\DependencyInjection\ContainerInterface;
use Psr\Container\ContainerInterface;



class ImageGenerator
{
    
    private $manager;

    private $container;


    public function __construct(EntityManagerInterface $manager,ContainerInterface $container)
    {
        $this->manager=$manager;

        $this->container = $container;

    }
    
    
    public function setImagePath(Collection $images,Produit $entityProduit)
    {
        $newProduit= new Produit();

        $newProduit->setNom($entityProduit->getNom())
        ->setDescription($entityProduit->getDescription())
        ->setPrix($entityProduit->getPrix())
        ->setCategorie($entityProduit->getCategorie());
       // ->addImage($imageProduit);
        
        $this->manager->persist($newProduit);

        $this->manager->flush();
        

        foreach($images as $image)
        {
            $imageFile=$image->getFile();

            if($imageFile)
            {
            
                    $imageName = md5(uniqid()).'.'.$imageFile->guessExtension();
                    $imageFile->move(
                        $this->container->getParameter('images_directory'), // define this parameter in your services.yaml
                        $imageName
                    );
                    
            
            

                $imageProduit=new ImageProduit();

                $imageProduit->setProduit($newProduit)
                                ->setPath($imageName);
                                
                $this->manager->persist($imageProduit);

                $this->manager->flush();
            

                

            }

        }
        
        
        
        
    }

    public function setProduitId(Produit $produit)
    {
        
       $imageProduit=$this->manager->getRepository(ImageProduit::class)->findBy(['produit'=>null]);

     
       if($imageProduit)
       {
          foreach($imageProduit as $imageP)
          {
              $imageP->setProduit($produit);

              $this->manager->flush();
          }
       }
        
       
    }
}