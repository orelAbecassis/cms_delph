<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeClientController extends AbstractController
{

    #[Route('/home/client', name: 'app_home_client')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('home_client/index.html.twig', [
            'controller_name' => 'HomeClientController',
            'user' =>$user->getUserIdentifier()
        ]);
    }
}
