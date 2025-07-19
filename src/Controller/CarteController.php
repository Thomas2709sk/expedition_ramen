<?php

namespace App\Controller;

use App\Repository\RamenRepository;
use App\Repository\SideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CarteController extends AbstractController
{
    #[Route('/carte', name: 'app_carte')]
    public function index(RamenRepository $ramenRepository, SideRepository $sideRepository): Response
    {
       $ramens = $ramenRepository->findAll();
        $sides = $sideRepository->findAll();

        return $this->render('carte/index.html.twig', [
            'ramens' => $ramens,
            'sides' => $sides,
        ]);
    }
}
