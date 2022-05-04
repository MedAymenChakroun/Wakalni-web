<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PDFController extends AbstractController
{
    /**
     * @Route("/pdf", name="pdf")
     */
    public function index(UserRepository $repo): Response
    {


        // Instantiate Dompdf with our options
        $dompdf = new Dompdf();

        $users = $repo->findAll();
        $sum = 0;
        $min = 100;
        $max = 18;
        foreach($users as $user) {
            $sum += $user->getAge();
            if($min > $user->getAge())
                $min = $user->getAge();
            if($max < $user->getAge())
                $max = $user->getAge();
        }

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('back/pdf.html.twig', [
            'users' => $users,
            'avg'=> $sum/count($users),
            'count' => count($users),
            'min' => $min,
            'max' => $max
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("users.pdf", [
            "Attachment" => true
        ]);
    }
}
