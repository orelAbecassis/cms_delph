<?php

namespace App\Controller;

use App\Entity\FichierDemande;
use App\Entity\User;
use App\Entity\InfoClient;
use App\Form\InfoClientType;
use App\Form\UserType;
use App\Repository\InfoClientRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/info/client')]
class InfoClientController extends AbstractController
{

    #[Route('/', name: 'app_info_client_index', methods: ['GET'])]
    public function index(InfoClientRepository $infoClientRepository): Response
    {
        $user = $this->getUser();
        return $this->render('info_client/index.html.twig', [
            'info_clients' => $infoClientRepository->findAll(),
            'user'=>$user->getUserIdentifier()
        ]);
    }

    #[Route('/new', name: 'app_info_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InfoClientRepository $infoClientRepository, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $infoClient = new InfoClient();
        $form = $this->createForm(InfoClientType::class, $infoClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $infoClientRepository->save($infoClient, true);

            return $this->redirectToRoute('app_info_client_index', [], Response::HTTP_SEE_OTHER);
        }

        $utilisateurs = $userRepository->findBy(['roles' => 'ROLE_ADMIN']);

        $listeNoms = [];
        foreach ($utilisateurs as $utilisateur) {
            $listeNoms[$utilisateur->getId()] = $utilisateur->getNom();
        }
        // dd($infoClient);
        // dd($listeNoms);
        // dd( $user->getUserIdentifier());
        // dd($form);

        return $this->renderForm('info_client/new.html.twig', [
            'info_client' => $infoClient,
            'form' => $form,
            'user' => $user->getUserIdentifier(),
            'listeNoms' => $listeNoms,
        ]);
    }


    #[Route('/show/{id}', name: 'app_info_client_show', methods: ['GET'])]
    public function show(InfoClientRepository $infoClient, $id): Response
    {
//        $clientData = $this->getUser($id);
//        dd($clientData);
        $client = $infoClient->find($id);
//        dd($client);
        $user = $this->getUser($id);
        return $this->render('info_client/show.html.twig', [
            'info_client' => $client,
            'user'=>$user->getUserIdentifier(),

        ]);
    }

    #[Route('/edit/{id}', name: 'app_info_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, InfoClient $infoClient, InfoClientRepository $infoClientRepository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(InfoClientType::class, $infoClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $infoClientRepository->save($infoClient, true);

            return $this->redirectToRoute('app_info_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('info_client/edit.html.twig', [
            'info_client' => $infoClient,
            'form' => $form,
            'user'=>$user->getUserIdentifier()
        ]);
    }

    #[Route('/delete/{id}', name: 'app_info_client_delete', methods: ['POST'])]
    public function delete(Request $request, InfoClient $infoClient, InfoClientRepository $infoClientRepository): Response
    {

        if ($this->isCsrfTokenValid('delete'.$infoClient->getId(), $request->request->get('_token'))) {
            $infoClientRepository->remove($infoClient, true);
        }

        return $this->redirectToRoute('app_info_client_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/mesColab', name:'mesColab', methods:['GET'])]
    public function index1(InfoClientRepository $infoClientRepository, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();
//        $count = $entityManager->getRepository(FichierDemande::class)->count_fichier($entityManager);
//        dd($count);
        $clients = $entityManager->getRepository(InfoClient::class)->findBy([
            'id_user' =>$user,
        ]);
//        dd($clients);
        return $this->render('info_client/index.html.twig', [
            'info_clients' => $clients,
            'user'=>$user->getUserIdentifier(),
//            'count'=>$infoClientRepository->count($count)
        ]);

    }

}
