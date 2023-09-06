<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\User;
use App\Form\CommandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{

    /**
     * @Route("/back", name="app_commande_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $commandes = $entityManager
            ->getRepository(Commande::class)
            ->findAll();

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("/new", name="app_commande_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{commandeid}", name="app_commande_show", methods={"GET"})
     */
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    /**
     * @Route("/{commandeid}/edit", name="app_commande_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{commandeid}", name="app_commande_delete", methods={"POST"})
     */
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getCommandeid(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }


/**
 * @Route("/", name="app_commande_search", methods={"GET"})
 */
public function search(Request $request, EntityManagerInterface $entityManager): JsonResponse
{
    // Get the search criteria from the request
    $searchValue = $request->query->get('search');

    // Create a query builder
    $queryBuilder = $entityManager->getRepository(Commande::class)->createQueryBuilder('c');
    $queryBuilder->leftJoin('c.clientid', 'u'); // Left join with clientid (assuming it's a User entity)

    // Add conditions based on the criteria
    if ($searchValue) {
        $queryBuilder
            ->orWhere('c.commandeid = :searchValue')
            ->orWhere('c.total = :searchValue')
            ->orWhere('c.datecreation LIKE :searchValue')
            ->orWhere('u.firstname LIKE :searchValue')
            ->setParameter('searchValue', '%' . $searchValue . '%');
    }

    // If the search value is numeric, filter by commandeid
    if (is_numeric($searchValue)) {
        $queryBuilder->andWhere('c.commandeid = :numericValue')
            ->setParameter('numericValue', $searchValue);
    }

    // Execute the query
    $results = $queryBuilder->getQuery()->getResult();

    // Create a serializer with both normalizers
    $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
    $serializer = new Serializer($normalizers);

    // Normalize the results
    $data = $serializer->normalize($results, null, ['attributes' => ['commandeid', 'datecreation', 'total', 'clientid' => ['firstname']]]);

    return new JsonResponse($data);
}

// public function search(Request $request, EntityManagerInterface $entityManager): JsonResponse
// {
//     // Get the search criteria from the request
//     $searchValue = $request->query->get('search');

//     // Create query builders for both Commande and User entities
//     $commandeQueryBuilder = $entityManager->getRepository(Commande::class)->createQueryBuilder('c');
//     $userQueryBuilder = $entityManager->getRepository(User::class)->createQueryBuilder('u');

//     // Add conditions based on the criteria for Commande
//     if ($searchValue) {
//         $commandeQueryBuilder
//             ->orWhere('c.commandeid = :searchValue')
//             ->orWhere('c.total = :searchValue')
//             ->orWhere('c.datecreation LIKE :searchValue')
//             ->setParameter('searchValue', '%' . $searchValue . '%');
//     }

//     // Execute the Commande query
//     $commandeResults = $commandeQueryBuilder->getQuery()->getResult();

//     // // Add conditions based on the criteria for User
//     // if ($searchValue) {
//     //     $userQueryBuilder
//     //         ->orWhere('u.firstname LIKE :searchValue')
//     //         ->setParameter('searchValue', '%' . $searchValue . '%');
//     // }

//     // // Execute the User query
//     // $userResults = $userQueryBuilder->getQuery()->getResult();

//     // Combine the results from both queries
//     $results = array_merge($commandeResults);

//     // Serialize the results as JSON
//     $serializer = new Serializer([new ObjectNormalizer()]);
//     $data = $serializer->normalize($results, null, ['attributes' => ['commandeid', 'datecreation', 'total', 'clientid' => ['firstname']]]);
//     foreach ($data as &$result) {
//         if ($result['datecreation'] instanceof \DateTimeInterface) {
//             $result['datecreation'] = $result['datecreation']->format('Y-m-d H:i:s');
//         }
//     }
//     return new JsonResponse($data);
// }

/**
 * Serialize Doctrine entities to JSON.
 *
 * @param array $entities
 *
 * @return string
 */
private function serializeResultsToJson(array $entities): string
{
    $data = [];

    foreach ($entities as $entity) {
        // Customize this part to format the data as you need
        $data[] = [
            'commandeid' => $entity->getCommandeid(),
            'datecreation' => $entity->getDatecreation()->format('Y-m-d H:i:s'),
            // Add other fields as needed
        ];
    }

    return json_encode($data);
}
}
// $queryBuilder = $entityManager->getRepository(Commande::class)->createQueryBuilder('c');
// $queryBuilder->leftJoin('c.clientid', 'u'); // Left join with clientid (assuming it's a User entity)