<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Reponse;
use App\Form\ReclamationType;
use App\Form\ReponseType;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;

/**
 * @Route("/reponse")
 */
class ReponseController extends AbstractController
{
    /**
     * @Route("/", name="app_reponse_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reponses = $entityManager
            ->getRepository(Reponse::class)
            ->findAll();

        return $this->render('reponse/index.html.twig', [
            'reponses' => $reponses,
        ]);
    }

    /**
     * @Route("/new/{state}/{idR}", name="app_reponse_newV")
     */
    public function newV($idR,$state,Request $request, EntityManagerInterface $entityManager, ReclamationRepository $repository): Response
    {
        $reclamation=$repository->find($idR);
        //dd($reclamation);
        $reponse = new Reponse();
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setEtat($state);
            $entityManager->persist($reclamation);
            $reponse->setReclamationid($reclamation);
            $entityManager->persist($reponse);

            $sid = 'ACe3aed7d915703dc5dfe168ddaf7a3f74';
            $token = 'f4e27a4b53468a114ba848292ad00bea';
            $client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!
            $client->messages->create(
            // the number you'd like to send the message to
                '+21655034697',
                [
                    // A Twilio phone number you purchased at twilio.com/console
                    'from' => '+17473003083',
                    // the body of the text message you'd like to send

                    'body' => 'La réclamation a été traité'
                ]
            );
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reponse/new.html.twig', [
            'reponse' => $reponse,
            'form' => $form->createView(),
            'idrec' =>$idR,
        ]);
    }

    /**
     * @Route("/{reponseid}", name="app_reponse_show", methods={"GET"})
     */
    public function show(Reponse $reponse): Response
    {
        return $this->render('reponse/show.html.twig', [
            'reponse' => $reponse,
        ]);
    }

    /**
     * @Route("/{reponseid}/edit", name="app_reponse_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reponse $reponse, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reponse/edit.html.twig', [
            'reponse' => $reponse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{reponseid}", name="app_reponse_delete", methods={"POST"})
     */
    public function delete(Request $request, Reponse $reponse, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponse->getReponseid(), $request->request->get('_token'))) {
            $entityManager->remove($reponse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/show/{id}", name="app_reponse_showbyid", methods={"GET"})
     */
    public function showbyid($id): Response
    {
        $rep=$this->getDoctrine()->getRepository(Reponse::class)->findOneBy(array('reclamationid'=>$id));

        return $this->render('reponse/show.html.twig', [
            'reponse' => $rep]);
    }
}
