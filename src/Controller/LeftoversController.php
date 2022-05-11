<?php

namespace App\Controller;

use App\Entity\Leftovers;
use App\Form\LeftoversType;
use App\Repository\LeftoversRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/leftovers")
 */
class LeftoversController extends AbstractController
{
    /**
     * @Route("/", name="app_leftovers_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,Request $request,LeftoversRepository  $repository,PaginatorInterface $paginator): Response
    {
        $leftovers = $entityManager
            ->getRepository(Leftovers::class)
            ->findAll();
        $search = $request->query->get("search");

        $leftovers = $repository->findAllWithSearch($search);
        if($search=="")
        $leftovers =$repository->triedecroissant();

        $leftovers=$paginator->paginate(
            $leftovers,
            $request->query->getInt('page',1),
            4
        );

        return $this->render('leftovers/index.html.twig', [
            'leftovers' => $leftovers,
        ]);
    }

    /**
     * @Route("/front", name="app_leftovers_indexx", methods={"GET"})
     */
    public function indexx(EntityManagerInterface $entityManager,Request $request,LeftoversRepository  $repository,PaginatorInterface $paginator): Response
    {
        $leftovers = $entityManager
            ->getRepository(Leftovers::class)
            ->findAll();
        $search = $request->query->get("search");

        $leftovers = $repository->findAllWithSearch($search);
        if($search=="")
            $leftovers =$repository->triedecroissant();

        $leftovers=$paginator->paginate(
            $leftovers,
            $request->query->getInt('page',1),
            4
        );

        return $this->render('leftovers/indexx.html.twig', [
            'leftovers' => $leftovers,
        ]);
    }

    /**
     * @Route("/stats", name="leftovers_stats", methods={"GET"})
     */
    public function statistics(LeftoversRepository $Repository, EntityManagerInterface $entityManager): Response
    {
        $leftoverss = $Repository->findAll();
        $leftoverName = [];
        $leftoverCount = [];
        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($leftoverss as $leftover){
            $leftoverName[] = $leftover->getSujet();
            $leftoverCount[]= count($leftoverss);
        }
        return $this->render('leftovers/stat.html.twig', [
            'leftoverName' => json_encode($leftoverName),
            'leftoverCount' => json_encode($leftoverCount)

        ]);
    }



    /**
     * @Route("/new", name="app_leftovers_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $leftover = new Leftovers();
        $form = $this->createForm(LeftoversType::class, $leftover);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($leftover);
            $entityManager->flush();

            return $this->redirectToRoute('app_leftovers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('leftovers/new.html.twig', [
            'leftover' => $leftover,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{leftoverid}", name="app_leftovers_show", methods={"GET"})
     */
    public function show(Leftovers $leftover): Response
    {
        return $this->render('leftovers/show.html.twig', [
            'leftover' => $leftover,
        ]);
    }

    /**
     * @Route("/{leftoverid}/edit", name="app_leftovers_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Leftovers $leftover, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LeftoversType::class, $leftover);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_leftovers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('leftovers/edit.html.twig', [
            'leftover' => $leftover,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{leftoverid}", name="app_leftovers_delete", methods={"POST"})
     */
    public function delete(Request $request, Leftovers $leftover, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$leftover->getLeftoverid(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($leftover);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_leftovers_index', [], Response::HTTP_SEE_OTHER);
    }


}
