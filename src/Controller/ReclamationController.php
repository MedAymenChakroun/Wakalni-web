<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Reclamation;
use App\Entity\Reponse;
use App\Entity\User;
use App\Form\ReclamationType;
use App\Repository\CommandeRepository;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use App\Controller\Swift_Mailer;
use Twilio\Rest\Client;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @Route("/reclamation")
 */
class ReclamationController extends AbstractController
{
    /**
     * @Route("/mobile/allreclamation", name="allrclamation")
     */

    public function allreclamation(ReclamationRepository $reclamationRepository){
        $reclamations=$reclamationRepository->findAll();
        $jsondata=array();
        $prd=array();
        $i=0;
        foreach ($reclamations as $reclamation) {
            $prd = array(
                'reclamationid' => $reclamation->getReclamationid(),
                'sujet' => $reclamation->getSujet(),
                'contenu' => $reclamation->getContenu(),
                'clientid' => $reclamation->getClientid(),
                'commandeid' => $reclamation->getCommandeid(),
                'etat' => $reclamation->getEtat(),

            );
            $jsonData[$i++] = $prd;
        }
        return new JsonResponse($jsonData);
    }

    /**
     * @Route("/", name="app_reclamation_index", methods={"GET"})
     */

    public function index(EntityManagerInterface $entityManager, ReclamationRepository $r): Response
    {


        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findAll();
        $contenu = $r->listByOrder();

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $contenu,
        ]);
    }

    /**
     * @Route("/new", name="app_reclamation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, CommandeRepository $repository, \Swift_Mailer $mailer): Response
    {

        $reclamation = new Reclamation();

        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $entityManager
                ->getRepository(User::class)
                ->find(1);
            $reclamation->setClientid($user);
            $entityManager->persist($reclamation);

            $entityManager->flush();

         /*     $sid = 'ACe3aed7d915703dc5dfe168ddaf7a3f74';
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
            );*/



            $message = (new \Swift_Message('Wakalni '))
                ->setFrom('wakalni801@gmail.com')
                ->setTo('lacht06@gmail.com')
                ->setBody('La réclamation envoyé avec succès '
                );

            $mailer->send($message);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }



        return $this->render('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);


    }

    /**
     * @Route("/{reclamationid}", name="app_reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation): Response
    {

        $RESP = $this->getDoctrine()->getRepository(Reponse::class)->findOneBy(['reclamationid' => $reclamation->getReclamationid()]);
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
            'reponse' => $RESP
        ]);
    }

    /**
     * @Route("/{reclamationid}/edit", name="app_reclamation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{reclamationid}", name="app_reclamation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reclamation->getReclamationid(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/searchResajax", name="searchResajax")
     */
    public function searchResajax(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Reclamation::class);
        $requestString=$request->get('searchValue');
        $reclamations = $repository->findRecBysujet($requestString);
        return $this->render('reclamation/ajaxRes.html.twig', [
            "reclamation"=>$reclamations,
        ]);
    }
    /**
     * @Route("/search/{searchString}", name="search")
     */
    public function search($searchString): JsonResponse
    {
        $serializer = new Serializer([new ObjectNormalizer()]);
        $repository = $this->getDoctrine()->getRepository(Reclamation::class);
        $reclamations = $repository->findBySujet($searchString);
        $data=$serializer->normalize($reclamations);
        return new JsonResponse($data);
    }
}
