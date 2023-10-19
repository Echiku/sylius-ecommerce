<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Produit;
use App\Entity\ImageProduit;
use Webmozart\Assert\Assert;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ContainerInterface;



class RouterEventListener
{
    private $manager;

    private $container;

    public function __construct(EntityManagerInterface $manager,ContainerInterface $container)
    {
        $this->manager=$manager;

        $this->container = $container;

    }
    
    
    public function onKernelRequest(GenericEvent $event)
    {
           
            $subject = $event->getSubject();

         

            //Créer un nouveau produit

            $newProduit= new Produit();

            $newProduit->setNom($subject->getNom())
            ->setDescription($subject->getDescription())
            ->setPrix($subject->getPrix())
            ->setCategorie($subject->getCategorie());
           // ->addImage($imageProduit);
            
            $this->manager->persist($newProduit);

            $this->manager->flush();

        /* Image

            $images=$subject->getImage();

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

        */
        

          

            //$exception =  $event->getException();
       



      
    }
}