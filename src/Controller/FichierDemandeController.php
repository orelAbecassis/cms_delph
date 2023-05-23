<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FichierDemandeController extends AbstractController
{
    #[Route('/fichierDemande', name: 'app_fichier_demande')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('fichier_demande/index.html.twig', [
            'controller_name' => 'FichierDemandeController',
            'user'=>$user->getUserIdentifier()
        ]);
    }
}
