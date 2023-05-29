<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\InfoClientRepository;

class FichierDemandeController extends AbstractController
{

    #[Route('/fichier/demande', name: 'app_fichier_demande')]
    public function index(InfoClientRepository $infoClientRepository): Response

    {
        $user = $this->getUser();
        return $this->render('fichier_demande/index.html.twig', [
            'info_clients' => $infoClientRepository->findAll(),
            'user'=>$user->getUserIdentifier(),
            'controller_name' => 'FichierDemandeController',
            'user'=>$user->getUserIdentifier()
        ]);
    }
}
