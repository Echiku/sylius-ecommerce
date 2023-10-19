<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Produit;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProduitFormSubmitListener 
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [FormEvents::POST_SUBMIT => 'onFormSubmit'];
    }

    public function onFormSubmit(FormEvent $event)
    {
        
      /*  
        $produit = $event->getData();
        if ($produit instanceof Produit) {
            $images = $produit->getImage();
            foreach ($images as $image) {
                $image->setProduit($produit);
                $this->entityManager->persist($image);
            }
            $this->entityManager->flush();
        }
        */
    }
}
