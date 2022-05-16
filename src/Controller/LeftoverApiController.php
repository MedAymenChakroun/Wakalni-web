<?php

namespace App\Controller;

use App\Entity\Leftovers;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/api", name="app_leftover_api")
 */
class LeftoverApiController extends AbstractController
{
    /**
     * @Route("/leftover/api", name="app_leftover_api")
     */
    public function index(): Response
    {
        return $this->render('leftover_api/index.html.twig', [
            'controller_name' => 'LeftoverApiController',
        ]);
    }


    /**
     * @Route("/leftovers", name="api_leftover")
     */
    public function allLeftOvers(NormalizerInterface $normalizer): Response
    {
        $leftovers = $this->getDoctrine()->getRepository(Leftovers::class)->findAll();
        $jsonContent = $normalizer->normalize($leftovers, 'json', ['groups' => 'api:leftover']);

        return new Response(
            json_encode($jsonContent),
            200,
            ['Accept' => 'application/json',
                'Content-Type' => 'application/json']);
    }




    /**
     * @Route("/leftover/add", name="api_leftover_add", methods={"POST"})
     */
    public function add(Request $request, NormalizerInterface $normalizer): Response
    {
        $user=$this->getDoctrine()->getRepository(Utilisateur::class)->find(10);
        $date = date_create('2000-01-01');


        $em = $this->getDoctrine()->getManager();
        $leftover = new Leftovers();
        $leftover->setSujet($request->request->get('sujet'));
        $leftover->setType($request->request->get('type'));
        $leftover->setQuantite(intval($request->request->get('quantite')));
        $leftover->setDateexpiration(date_format($date, 'Y-m-d H:i:s'));
        $leftover->setChefrestoid($user);
        $em->persist($leftover);
        $em->flush();
        return new Response(
            "{\"response\": \"leftover  created.\"}",
            200, ['Accept' => 'application/json',
            'Content-Type' => 'application/json']);
    }

    /**
     * @Route("/leftover/update", name="api_leftover_update", methods={"POST"})
     */
    public function update(Request $request, NormalizerInterface $normalizer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $leftover = $this->getDoctrine()->getRepository(leftovers::class)->find(intval($request->request->get('leftoverid')));

        $leftover->setSujet($request->request->get('sujet'));
        $leftover->setType($request->request->get('type'));
        $leftover->setQuantite($request->request->get('quantite'));
       // $leftover->setDateexpiration($request->request->get('dateexpration'));

        $em->persist($leftover);
        $em->flush();
        return new Response(
            "{\"response\": \" leftover updated.\"}",
            200, ['Accept' => 'application/json',
            'Content-Type' => 'application/json']);
    }

    /**
     * @Route("/leftover/delete", name="api_ leftover_delete" )
     */

    public function delete(Request $request, NormalizerInterface $normalizer): Response
    {
//
//        if (!$request->query->get('username'))
//            return new Response(
//                '{"error": "Missing username."}',
//                400, ['Accept' => 'application/json',
//                'Content-Type' => 'application/json']);
        $leftover = $this->getDoctrine()->getRepository( leftovers::class)->find(intval($request->request->get('leftoverid')));


        $em = $this->getDoctrine()->getManager();
        $em->remove( $leftover);
        $em->flush();
        return new Response(
            "{\"response\": \" leftover deleted.\"}",
            200, ['Accept' => 'application/json',
            'Content-Type' => 'application/json']);
    }
}
