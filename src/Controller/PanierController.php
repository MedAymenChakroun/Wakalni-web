<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Form\PanierType;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="app_panier_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $paniers = $entityManager
            ->getRepository(Panier::class)
            ->findAll();


            $total = 0;


            // foreach($paniers as $Panier){
            //     $totalPanier = $Panier['produit']->getPrixprod() * $Panier['quantite'];
            //     $total += $totalPanier;
            // }

        return $this->render('panier/index.html.twig', [
            'paniers' => $paniers,
            // 'total' => $total
        ]);
    }

    /**
     * @Route("/panier/new", name="app_panier_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $panier = new Panier();
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);
        $errors = $validator->validate($panier);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($panier);
            $entityManager->flush();

            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('panier/new.html.twig', [
            'panier' => $panier,
            'form' => $form->createView(),
        ]);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        }
        
        return new Response('The author is valid! Yes!');
        if (count($errors) > 0) {
            return $this->render('panier/new.html.twig', [
                'errors' => $errors,
            ]);
        }

    }
    // /**
    //  * @Route("/delete/{panierid}", name="app_panier_delete",methods={"GET","POST","DELETE"})
    //  */
    // public function delete(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$panier->getPanierid(), $request->request->get('_token'))) {
    //         $entityManager->remove($panier);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
    // }


/**
     * @Route("/panier/delete/{panierid}", name="app_panier_delete",methods={"GET", "DELETE", "POST"})
     */
    public function delete(Request $request, Panier $panier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panier->getPanierid(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($panier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
    }


     /**
     * @Route("/checkout", name="app_panier_chekcout", methods={"GET", "POST"})
     */
    public function checkout(Request $request, EntityManagerInterface $entityManager): Response
    {   $timestamp = date('Y-m-d H:i:s');
        $timestampu = date('Y-m-d H:i:s', strtotime("+15 minutes"));
        $timestampp = date('Y-m-d H:i:s', strtotime("+1 hours"));
        // $y= $_COOKIE['panierid'];
        $oi= $_COOKIE['userID'];
        // $y_value = intval( $y );
     
             $sql = " INSERT INTO commande(datecreation,dateexpedition,datearrivee,clientid,panierid)
             VALUES ('$timestamp' ,'$timestampu' ,'$timestampp',$oi,340);";
             $stmt = $entityManager->getConnection()->prepare($sql);
             $result = $stmt->executeQuery();
            
        $x= $_COOKIE['total'];
        $int_value = intval( $x );
    \Stripe\Stripe::setApiKey('sk_test_51KbYCPCmIH5b4ki3O2XgjSXQB7zwZ8jktL7T7k26PLnliyEvwh5xts9P7o8aX3ndeONnCdwNyuFSgo5hWD31pg1n00o01oKIwU');
    $session = \Stripe\Checkout\Session::create([
        'line_items' => [[
          'price_data' => [
            'currency' => 'eur',
            'product_data' => [
              'name' => 'Panier',
            ],
            'unit_amount' => $int_value,
          ],
          'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'http://127.0.0.1:8000/produit',
        'cancel_url' => 'http://127.0.0.1:8000/panier',
      ]);
      return $this->redirect($session->url, 303);
}
}