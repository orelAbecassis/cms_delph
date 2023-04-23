<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeAdminController extends AbstractController
{
    #[Route('/home/admin', name: 'app_home_admin')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('home_admin/index.html.twig', [
            'controller_name' => 'HomeAdminController',
            'user'=>$user->getUserIdentifier()
        ]);
    }


}
