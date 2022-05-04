<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Livraison;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;

class FrontController extends AbstractController
{
    /**
     * @Route("/front", name="app_front")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(UserType::class, $this->getUser());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            //$uploads_directory = $this->getParameter('uploads_directory');

            $filename = md5(uniqid()) . '.' . $image->guessExtension();
            $image->move(
                'uploads_directory',
                $filename

            );
            $this->getUser()->setImage($filename);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('app_front');
        }

        return $this->render('front/profile_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/deleteAccount", name="profile_delete")
     */
    public function delete_profile(): Response
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($this->getUser()->getId());

        $session = $this->get('session');
        $session = new Session();
        $session->invalidate();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('registration');

    }
    /**
     * @Route("/commande", name="commande")
     */
    public function commander(): Response
    {
        $commande = $this->getDoctrine()->getManager()->getRepository(Commande::class)->findAll();
        return $this ->render('front/livrer.html.twig',[
            'c'=>$commande
        ]);
    }
    /**
     * @Route("/{id}/livrer", name="livrer")
     */
    public function livrer(Request $request, commande $commande, EntityManagerInterface $em)
    {
        $livraison = new livraison();

        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($this->getUser()->getId());


        $livraison->setIdcommande($commande);
        $livraison->setIdlivreur($user);
        $livraison->setProgress(0);


        $em = $this->getDoctrine()->getManager();
        $em->persist($livraison);


        /* $phone=$commande->getClientid()->getPhonenumber();
        $name=$commande->getClientid()->getFirstname();
         $account_sid = 'AC06fc9eac703b802c62c0f697f66fb0ed';
        $auth_token = '264a52e3279647d637645241bfe8f2ef';
        $twilio_number = "+19378263616";
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
        // Where to send a text message (your cell phone?)
            "+216$phone",
            array(
                'from' => $twilio_number,
                'body' => "Bonjour,$name  Votre livraison est arrivee"
            )
        ); */
        $em->flush();



        return $this->redirectToRoute('livraison');

    }

    /**
     * @Route("/livraison", name="livraison")
     */
    public function livraison(): Response
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($this->getUser()->getId());
        $livraisons = $this->getDoctrine()->getManager()->getRepository(Livraison::class)->findByIDLivreur($user->getId());
        return $this ->render('front/livraison_livreur.html.twig',[
            'l'=>$livraisons
        ]);
    }

    /**
     * @Route("/{id}/delete_livraison",name="livraison_delete")
     */
    public function delete_livraison($id){
        $livraison= $this->getDoctrine()->getRepository(livraison::class)->find($id);
        $em= $this->getDoctrine()->getManager();
        $em->remove($livraison);
        $em->flush();
        $this->addFlash('message', 'Suppression avec succée !');
        return $this->redirectToRoute("commande");

    }


    /**
     * @Route("/{id}/done",name="livraison_done")
     */
    public function done($id){
        $livraison= $this->getDoctrine()->getRepository(livraison::class)->find($id);
        $livraison->setProgress(1);
        $em= $this->getDoctrine()->getManager();
        $em->flush();
        $this->addFlash('message', 'modification reussit avec succée !');
        return $this->redirectToRoute("livraison");

    }

    /**
     * @Route("/livraisonsorta", name="sortliva")
     */
    public function sortLivA(): Response
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($this->getUser()->getId());
        $livraisons = $this->getDoctrine()->getManager()->getRepository(Livraison::class)->findByIDLivreur($user->getId())->sortByDateExpirationA();
        return $this ->render('front/livraison_livreur.html.twig',[
            'la'=>$livraisons
        ]);
    }
    /**
     * @Route("/livraisonsortd", name="sortlivd")
     */
    public function sortLivd(): Response
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($this->getUser()->getId());
        $livraisons = $this->getDoctrine()->getManager()->getRepository(Livraison::class)->findByIDLivreur($user->getId())->sortByDateExpirationD();
        return $this ->render('front/livraison_livreur.html.twig',[
            'ld'=>$livraisons
        ]);
    }

}
