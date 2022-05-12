<?php

namespace App\Controller;
use App\Entity\Offre;
use App\Form\OffreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commande;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Form\PanierType;

/**
 * @Route("/backoffre")
 */
class OffreControllerBack extends AbstractController
{
    /**
     * @Route("/", name="app_backoffre_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $offres = $entityManager
            ->getRepository(Offre::class)
            ->findAll();

        return $this->render('offre/index2.html.twig', [
            'offres' => $offres,
        ]);
    }

    /**
     * @Route("/new", name="app_backoffre_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre/new.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{offreid}", name="app_backoffre_show", methods={"GET"})
     */
    public function show(Offre $offre): Response
    {
        return $this->render('offre/show.html.twig', [
            'offre' => $offre,
        ]);
    }

    /**
     * @Route("/{offreid}/edit", name="app_backoffre_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre/edit.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{offreid}", name="app_backoffre_delete", methods={"POST"})
     */
    public function delete(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getOffreid(), $request->request->get('_token'))) {
            $entityManager->remove($offre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
    }
       /**
     * @Route("/{offreid}/showw", name="app_backoffre_showw", methods={"GET", "POST"})
     */
    public function getSqlResult(EntityManagerInterface $em, Offre $offre, EntityManagerInterface $entityManager, Request $request)
    {

            $x= $_COOKIE['quantity'];
            $int_value = intval( $x );
        $id = $offre->getProduitid();
        $idp = $id->getProduitid();
        $iu= $_COOKIE['userID'];

        $prix = $offre->getPrix() * $int_value ;
        $sql = " INSERT INTO Panier(produitid,clientid,quantite,prixprod)
        VALUES ($idp,$iu,$int_value ,$prix);";

        $stmt = $em->getConnection()->prepare($sql);
        $result = $stmt->executeQuery();
        $paniers = $entityManager
            ->getRepository(Panier::class)
            ->findAll();
        return $this->render('panier/index.html.twig', [
            'paniers' => $paniers,
            // 'total' => $total
        ]);
    }
}
