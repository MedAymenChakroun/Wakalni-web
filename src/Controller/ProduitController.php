<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Utilisateur;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use App\Entity\Panier;
use App\Form\PanierType;



/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="app_produit_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $produits = $entityManager
            ->getRepository(Produit::class)
            ->findAll();

        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    /**
     * @Route("/new", name="app_produit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{produitid}", name="app_produit_show", methods={"GET"})
     */
    public function show(Produit $produit, LoggerInterface $logger): Response
    {   
         dd($produit->getNom());
        


       
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
            
        ]);
    }
     /**
     * @Route("/{produitid}", name="app_produit_show")
     */
    public function getSqlResult(EntityManagerInterface $em,Produit $produit,EntityManagerInterface $entityManager ) : Response
{   

    $id = $produit->getProduitid();
    $prix = $produit->getPrix()*5;
    


    $sql = " 
        INSERT INTO Panier(produitid,clientid,quantite,prixprod)
        VALUES ($id,1,5,$prix);";

    $stmt = $em->getConnection()->prepare($sql);
    $result = $stmt->executeQuery();
    $paniers = $entityManager
            ->getRepository(Panier::class)
            ->findAll();
            dd($paniers);
            // return $this->render('panier/index.html.twig', [
            //     'paniers' => $paniers,
            //     // 'total' => $total
            // ]);
}   



    /**
     * @Route("/{produitid}", name="app_produit_panier", methods={"GET"})
     */
    // public function data(Produit $produit, LoggerInterface $logger): Response
    // {   
       



    //       return $this->render('produit/show.html.twig', [
    //         'produit' => $produit,
            
    //     ]);

    // }


    /**
     * @Route("/{produitid}/edit", name="app_produit_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{produitid}", name="app_produit_delete", methods={"POST"})
     */
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getProduitid(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/{produitid}", name="app_produit_show", methods={"GET"})
     */
    // public function test($produitid)
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     // $RAW_QUERY = "SELECT u.nom FROM `utilisateur` u, `produit` p WHERE u.id=p.crid AND p.crid=$produitid;";
    //     $statement = $this->$em->prepare("SELECT u.nom FROM `utilisateur` u, `produit` p WHERE u.id=p.crid AND p.crid=$produitid");
    //     $statement->execute();
    //     $result = $statement->fetchAll();
    //     return $this->render('produit/show.html.twig', [
    //         'result' => $result,
    //     ]);
    // }


    // public function test(Utilisateur $Utilisateur): Response
    // {
    //     $connection = $this->getDoctrine()->getManager();
    //             $query = "SELECT u.nom FROM `utilisateur` u, `produit` p WHERE u.id=p.crid AND p.crid=1;";
        // return $this->render('produit/show.html.twig', [
        //     'chef' => $Utilisateur,
        // ]);
    // }




 

}
