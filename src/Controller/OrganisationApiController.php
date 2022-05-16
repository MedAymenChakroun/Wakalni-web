<?php

namespace App\Controller;

use App\Entity\Leftovers;
use App\Entity\Organisation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/api")
 */
class OrganisationApiController extends AbstractController
{
    /**
     * @Route("/organisation/api", name="app_organisation_api")
     */
    public function index(): Response
    {
        return $this->render('organisation_api/index.html.twig', [
            'controller_name' => 'OrganisationApiController',
        ]);
    }

    /**
     * @Route("/organisations", name="api_tentes")
     */
    public function allOrganisations(NormalizerInterface $normalizer): Response
    {
        $tentesList = $this->getDoctrine()->getRepository(Organisation::class)->findAll();
        $jsonContent = $normalizer->normalize($tentesList, 'json', ['groups' => 'api:organisation']);
        return new Response(
            json_encode($jsonContent),
            200,
            ['Accept' => 'application/json',
                'Content-Type' => 'application/json']);
    }

    /**
     * @Route("/organisation/add", name="api_add_tente")
     */
    public function add(NormalizerInterface $normalizer,Request $request): Response
    {

        $organisation = new Organisation();

        $organisation->setNom($request->request->get('nom'));
        $organisation->setEmail($request->request->get('email'));
        $organisation->setNumero($request->request->get('numero'));
        $organisation->setAdresse($request->request->get('adresse'));
        $organisation->setLeftoverid($this->getDoctrine()->getRepository(Leftovers::class)->find(intval($request->request->get('leftoverid'))));

//        $file=new File($request->request->get('image'));
//        $fileName = md5(uniqid()) . '.jpg';
//        $tente->setImage($fileName);
//        $file->move($this->getParameter('tente_image_directory'), $fileName);

        $em=$this->getDoctrine()->getManager();
        $em->persist($organisation);
        $em->flush();
        $jsonContent = $normalizer->normalize($organisation, 'json', ['groups' => 'api:tente']);
        return new Response(
            json_encode($jsonContent),
            200,
            ['Accept' => 'application/json',
                'Content-Type' => 'application/json']);
    }

    /**
     * @Route("/organisation/update", name="api_update_organisation")
     */
    public function update(NormalizerInterface $normalizer,Request $request): Response
    {

        $organisation = $this->getDoctrine()->getRepository(Organisation::class)->find(intval($request->request->get('id')));

        $organisation->setNom($request->request->get('nom'));
        $organisation->setEmail($request->request->get('email'));
        $organisation->setNumero(intval($request->request->get('numero')));
        $organisation->setAdresse($request->request->get('adresse'));

        $em=$this->getDoctrine()->getManager();
        $em->persist($organisation);
        $em->flush();
        $jsonContent = $normalizer->normalize($organisation, 'json', ['groups' => 'api:organisation']);
        return new Response(
            json_encode($jsonContent),
            200,
            ['Accept' => 'application/json',
                'Content-Type' => 'application/json']);
    }

    /**
     * @Route("/organisation/delete", name="api_organisation_delete")
     */
    public function delete(Request $request, NormalizerInterface $normalizer): Response
    {

        $organisation = $this->getDoctrine()->getRepository(Organisation::class)->find(intval($request->request->get('organisationid')));

        $em = $this->getDoctrine()->getManager();
        $em->remove($organisation);
        $em->flush();
        return new Response(
            "{\"response\": \"Organisation deleted.\"}",
            200, ['Accept' => 'application/json',
            'Content-Type' => 'application/json']);
    }
}
