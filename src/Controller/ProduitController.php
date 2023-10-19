<?php

namespace App\Controller;

use App\Entity\ImageProduit;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProduitController extends ResourceController
{
     
   /*
    public function createAction(Request $request): Response
    {
            
            dd('test');
        
            $produit = new Produit();
            $form = $this->createForm(ProduitType::class, $produit);
            $form->handleRequest($request);

           

            

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($produit);
                $entityManager->flush();

                // Handle redirection or other actions
                $imageProduit=new ImageProduit();

                $imageProduit->setProduit($produit);

                $entityManager->persist($imageProduit);
                
                $entityManager->flush();
                

                
                


            }

        return $this->redirectToRoute('app_admin_produit_index');
    }
    
    */

    public function listProduit(): Response
    {

         $listProduits=$this->getDoctrine()->getRepository(Produit::class)->findAll();

         return $this->render('_produit.html.twig',[
            'produits'=>$listProduits
         ]);

    }

    

   
}
