<?php

namespace App\Controller;

use Omnipay\Omnipay;
use App\Entity\Payment;
use App\Entity\CustomPayment;
use PhpParser\Node\Stmt\TryCatch;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OperationController extends AbstractController
{

    private $gateway;
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->gateway=Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId($_ENV['PAYPAL_CLIENT_ID']);
        $this->gateway->setSecret($_ENV['PAYPAL_SECRET_KEY']);
        $this->gateway->setTestMode(true);

        $this->manager=$manager;
    }
    
    
    //Checkout and payment // Validation et paiement

    
    public function paymentAction(Request $request): Response
    {
       
        $bag=$request->request;

        
        $amount=$bag->all()['amount'];

        $data=$bag->all()['sylius_checkout_select_payment'];

       

        $amount=str_replace('$US','',$amount);
        //check form's token for security // Check si le token du formulaire est valide pour raison de sécurité. 
        $token=$data['_token'];

       /*

        if(!$this->isCsrfTokenValid('myform',$token))
        {
            return new Response('Operation not allowed', Response::HTTP_BAD_REQUEST, 
            ['content-type'=>'text/plain']);
        }
        */
        $url=$request->headers->get('origin');
      

        try {
            $response= $this->gateway->purchase(array(
                'amount'=>$amount,
                'currency'=>$_ENV['PAYPAL_CURRENCY'],
                'returnUrl'=>$url.'/success',
                'cancelUrl'=>$url.'/error'
            ))->send();

            if($response->isRedirect())
            {
                $response->redirect();
            }

            else
            {
                return $response->getMessage();
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
       

        return $this->render('operation/index.html.twig');
    }


    //Success op // si l'operation est un succès
    
    public function success(Request $request)
    {
         if($request->query->get('paymentId') && $request->query->get('PayerID'))
         {
            $operation = $this->gateway->completePurchase(array(
                'payer_id'=>$request->query->get('PayerID'),
                'transactionReference'=>$request->query->get('paymentId')
            ));

            $response=$operation->send();

            if($response->isSuccessful())
            {
                $arr=$response->getData();

                

                 $payment= new CustomPayment();

                 $payment->setPaymentId($arr['id'])
                          ->setPayerId($arr['payer']['payer_info']['payer_id'])
                          ->setPayerEmail($arr['payer']['payer_info']['email'])
                          ->setAmount($arr['transactions'][0]['amount']['total'])
                          ->setCurrency($_ENV['PAYPAL_CURRENCY'])
                          ->setPurchasedAt(new \DateTime())
                          ->setPaymentStatus($arr['state']);

                $this->manager->persist($payment);
                $this->manager->flush();

                $name=$arr['transactions'][0]['item_list']['shipping_address']['recipient_name'];

                return $this->render('_success.html.twig',
                [
                    'message'=>"Le paiement de votre commande a été fait ave succès avec PayPal."
                ]);
            }
            else
            {
                return $this->render('_success.html.twig',[
                    'message'=>$response->getMessage()
                ]);
            }
         }

         else
         {
            return $this->render('_success.html.twig',[
                'message'=>'Paiment annulé !'
            ]);
         }
    }


  
    public function error()
    {
       return $this->render('_error.html.twig',[
        'message'=>'l\'utilisateur a annulé sa commande !'
       ]);
    }

    
   
}