<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Order\Order;
use App\Entity\OrderProduit;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sylius\Bundle\CoreBundle\Controller\ProductController as BaseProductController;


class CartController extends AbstractController
{
    
    private $manager;

   public function __construct(EntityManagerInterface $manager)
   {
       $this->manager=$manager;
   }
    
   
    
    public function addToCart(Request $request): Response
    {
        $data=json_decode($request->getContent(),true);
        
        //Récupération des champs
           
           // $itemProduit=$data['sylius_add_to_cart[cartItem][variant][jeans_size]'];

            $quantitéProduit=$data['sylius_add_to_cart[cartItem][quantity]'];

            $token=$data['sylius_add_to_cart[_token]'];

            $idProduit=$data['idProduit'];

                    //Validation du token

        if ($this->isCsrfTokenValid('941036.RccwpbtTYaVLvyW38gmijC9JsvHjkEeYLrJd2DuF7PE.P_B-6fRrA9wd13z4m0fmy04ZgqiVp3bUfdkWvFX8tsMTg0jy6RJT7AXVQg', $token)) {
            
            throw $this->createNotFoundException('Token non trouvé et non conforme!');

        }
        
        //Récuperation du produit
       $produit=$this->manager->getRepository(Produit::class)->findOneProduit($idProduit);

       if (!$produit) {
        throw $this->createNotFoundException('Aucun produit trouvé!');
    }


        //Calcul du choix de l'item.

       $itemTotal=$quantitéProduit * $produit[0]['prix'];

       $estimationCost=1.42;

       $taxes=9.35;

       $ordreTotal=$itemTotal + $estimationCost + $taxes;

       $ordreTotal=number_format($ordreTotal, 2);

       

        $arrayCart=['itemsTotal'=>$itemTotal,'estimationCost'=>$estimationCost,'taxes'=>$taxes,'orderTotal'=>$ordreTotal,'imagePath'=>$produit[0]['image'],'quantiteP'=>$quantitéProduit,'nomP'=>$produit[0]['nom'],'prix'=>$produit[0]['prix']];

        //On peut créer un ordre ici pour sauvegarder le choix de l'utilisateur connecté.
        
        return $this->json($arrayCart,200);

        
    }

   

    
    public function showCart(): Response
    {
        return $this->render('_cart.html.twig',[
            
         ]);

         
    }

    public function createOrder(Request $request): Response
    {
           //handling the form
           $data=json_decode($request->getContent(),true);

           dd($data);

           $items=$data['item'];

            $nomP=$data['nomP'];

            $quantiteP=$data['quantiteP'];

            $taxes=$data['taxes'];

            $est_ship=$data['est_ship'];

            $orderT=$data['orderT'];

            $imagePath=$data['îmagePath'];


         

           
            
          /* $this->forward("App\Controller\CartController::checkOut",
           ['data'=>$data]);
           */

           return $this->json('succès,200');
    }

    public function checkOut(Request $request): Response
    {

        $order_tab=json_decode($request->query->get('data'),true);

        

         

        return $this->render('_checkout.html.twig',['order'=>$order_tab]);
    }

    public function adrBill(Request $request): Response
    {
        
       
        $bag=$request->request;

        $data=$bag->all()['sylius_checkout_address'];

        
         
        //Récupération des elements du formulaire
           $email=$data['customer']['email'];
          
           $nom=$data['billingAddress']['firstName'];
           $prenom=$data['billingAddress']['lastName'];
           $entreprise=$data['billingAddress']['company'];
           $adresse=$data['billingAddress']['street'];
           $phone=$data['billingAddress']['phoneNumber'];

           $token=$data['_token'];

          
           
           //On peut gerer le control du formulaire en vérifiant le CSRF

           
           //On va alimenter une table cliente

           $client=new Client();

           $client->setEmail($email)
                  ->setResidence($adresse)
                  ->setEntreprise($entreprise)
                  ->setNom($nom)
                  ->setPrenom($prenom)
                  ->setTelephone($phone);

            $this->manager->persist($client);
 
            $this->manager->flush();

        //On va alimenter une table Ordre

        $orderJson=json_decode( $order=$request->query->get('data'),true);

        
        $items=str_replace('$','',$orderJson['itemT']);

        $estship=str_replace('$','',$orderJson['est_ship']);

        $taxes=str_replace('$','',$orderJson['taxes']);

        $ot=str_replace('$','',$orderJson['orderT']);


        

       $order=new OrderProduit();
        
        $order->setItemsTotal(floatval($items))
        ->setEstimationCout(floatval($estship))
        ->setTaxes(floatval($taxes))
        ->setImagePath($orderJson['imagePath'])
        ->setQuantite($orderJson['quantiteP'])
        ->setNomProduit($orderJson['nomP'])
        ->setOrderTotal(floatval($ot))
        ->setOrderAt(new \DateTime())
        ->addClient($client);

        $this->manager->persist($order);

        $this->manager->flush();


        //sauvegarde l'email en session

        $this->addFlash($email,'email');

                  

         return $this->render('_shipping.html.twig',['order'=>$order, 'email'=>$email]);
    }
   
   
    public function shipping(Request $request): Response
    {
           //handling the form
           $data=json_decode($request->getContent(),true);

           $info_shipment=$data['jsonString2'];

           //Check du token comme dans les methods précédentes

           // On peut save le choix du shippement

           
          return $this->json('success',200);
           

    }
    
    
    public function payment(): Response
    {
        return $this->render('_payment.html.twig');

    }



    
}
