<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BackController extends AbstractController
{
    /**
     * @Route("/back", name="app_back")
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this ->render('back/index.html.twig',[
            'u'=>$users
        ]);
    }
    /**
     * @Route("/settings", name="profile_settings")
     */
    public function settings(Request $request): Response
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
            return $this->redirectToRoute('app_back');
        }

        return $this->render('back/profilesettings.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_back', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete",name="user_delete")
     */
    public function delete_user($id){
        $user= $this->getDoctrine()->getRepository(user::class)->find($id);
        $em= $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        $this->addFlash('message', 'Suppression avec succée !');
        return $this->redirectToRoute("app_back");

    }
    /**
     * @Route("/role", name="affect_role")
     */
    public function affect_role(UserRepository $repo, Request $request, LoggerInterface $log): Response
    {
        $form = $this->createFormBuilder();

        $form->add('Users', EntityType::class, [
            'class' => User::class,
            'choice_label' => 'email'
        ]);

        $form->add('Roles', ChoiceType::class, [
            'choices' => [
                'User' => 'ROLE_USER',
                'Admin' => 'ROLE_ADMIN',
                'Livreur' => 'ROLE_LIVREUR',
                'Chef' => 'ROLE_CHEF'
            ]
        ]);

        $form = $form->getForm();

        if($form->handleRequest($request)){
            if($form->isSubmitted() && $form->isValid()){
                $data = $form->getData();
                $data["Users"]->setRoles([$data["Roles"]]);
                $this->getDoctrine()->getManager()->persist($data['Users']);
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('app_back');
            }
        }

        return $this->render('back/affecter_role.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/listLivraison", name="livraison_list")
     */
    public function listLivraison(): Response
    {
        $livraisons = $this->getDoctrine()->getManager()->getRepository(Livraison::class)->findAll();
        return $this ->render('back/listlivraison.html.twig',[
            'l'=>$livraisons
        ]);
    }

    /**
     * @Route("/{id}/editLivraison", name="Livraison_edit")
     */
    public function edit_livraison(UserRepository $repo, livraison $livraison, Request $request, LoggerInterface $log): Response
    {
        $form = $this->createFormBuilder();

        $form->add('Progres', ChoiceType::class, [
            'choices' => [
                'En cours' => 0,
                'Complete' => 1,
            ]
        ]);

        $form = $form->getForm();

        if($form->handleRequest($request)){
            if($form->isSubmitted() && $form->isValid()){
                $data = $form->getData();
                $livraison->setProgress($data["Progres"]);
                $this->getDoctrine()->getManager()->persist($livraison);
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('livraison_list');
            }
        }

        return $this->render('back/edit_livraison.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/{id}/delete_livraison",name="delete_livraison")
     */
    public function delete_livraison($id){
        $livraison= $this->getDoctrine()->getRepository(livraison::class)->find($id);
        $em= $this->getDoctrine()->getManager();
        $em->remove($livraison);
        $em->flush();
        $this->addFlash('message', 'Suppression avec succée !');
        return $this->redirectToRoute('livraison_list');

    }

    /**
     * @Route("/search/{searchString}", name="search")
     */
    public function search($searchString): JsonResponse
    {
        $serializer = new Serializer([new ObjectNormalizer()]);
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findByEmail($searchString);
        $data=$serializer->normalize($users);
        return new JsonResponse($data);
    }
}
