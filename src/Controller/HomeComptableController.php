<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeComptableController extends AbstractController
{

    #[Route('/home/comptable', name: 'app_home_comptable')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('home_comptable/index.html.twig', [
            'controller_name' => 'HomeComptableController',
            'user' =>$user->getUserIdentifier()
        ]);
    }
}
