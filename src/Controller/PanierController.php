<?php

namespace App\Controller;

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
 * @Route("/panier")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="app_panier_index", methods={"GET"})
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
     * @Route("/new", name="app_panier_new", methods={"GET", "POST"})
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
     * @Route("/delete/{panierid}", name="app_panier_delete",methods={"GET", "DELETE", "POST"})
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
}
