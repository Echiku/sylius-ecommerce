<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitActionController extends AbstractController
{
   private $manager;

   public function __construct(EntityManagerInterface $manager)
   {
       $this->manager=$manager;
   }
  
    public function listProduit(): Response
    {
        
        $listProduits=$this->manager->getRepository(Produit::class)->findListProduit();

        return $this->render('_produit.html.twig', [
            'produits' => $listProduits,
        ]);
    }

    public function oneProduit($id): Response
    {
        
        $oneProduit=$this->manager->getRepository(Produit::class)->findOneProduit($id);

        if($oneProduit)
        {
           
            return $this->render('_one-produit.html.twig', [
                'produit' => $oneProduit[0],
                'idProduit'=>$oneProduit[0]['id']
            ]); 

        }

       

       
    }

    public function addToCarts(Request $request,$id): Response
    {
        
        $data=json_decode($request->getContent(),true);
        
        //Récupération des champs
           
            $itemProduit=$data['sylius_add_to_cart[cartItem][variant][jeans_size]'];

            $quantitéProduit=$data['sylius_add_to_cart[cartItem][quantity]'];

            $token=$data['sylius_add_to_cart[_token]'];

            $idProduit=$data['idProduit'];
            
        
        
        //Validation du token

        if ($this->isCsrfTokenValid('941036.RccwpbtTYaVLvyW38gmijC9JsvHjkEeYLrJd2DuF7PE.P_B-6fRrA9wd13z4m0fmy04ZgqiVp3bUfdkWvFX8tsMTg0jy6RJT7AXVQg', $token)) {
            
            dd("Générer un message d'erreur");
        }
        
        //Récuperation du produit

        $produit=$this->manager->getRepository(Produit::class)->find($idProduit);

        //Cart & Order

        if (!$produit) {
            throw $this->createNotFoundException('Aucun produit trouvé!');
        }

        // Get the cart from the session
        $cart = $this->get('sylius.context.cart')->getCart();

        // Create a new cart item and add it to the cart
        $cartItem = $this->get('sylius.factory.cart_item')->createNew();
        $cartItem->setProduct($produit)
        ->setQuantity($quantitéProduit);

        $cart->addItem($cartItem);

        // Save the cart
        $this->get('sylius.manager.order')->persist($cart);
        $this->get('sylius.manager.order')->flush();




         return $this->render('_cart.html.twig',[
            'cart'=>$cart
         ]);

    }

    

    
}
