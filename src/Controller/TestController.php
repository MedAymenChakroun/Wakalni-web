<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="app_test")
     */
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    /**
     * @Route("/test", name="test1", methods={"GET"})
     */
    public function getRcid()
     {
        $repository = $this->getDoctrine()->getManager()
        ->getRepository('ERPSDBundle:Produit');
        $result = $repository->findAll();
        return $result;
     }
     
}
