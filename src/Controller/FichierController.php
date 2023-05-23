<?php

namespace App\Controller;

use App\Entity\Fichier;
use App\Form\FichierType;
use App\Repository\FichierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

#[Route('/fichier')]
class FichierController extends AbstractController
{
    #[Route('', name: 'app_fichier_index', methods: ['GET'])]
    public function index(FichierRepository $fichierRepository): Response
    {
        $user =$this->getUser();
        return $this->render('fichier/index.html.twig', [
            'fichiers' => $fichierRepository->findAll(),
            'user'=>$user->getUserIdentifier()
        ]);
    }

    #[Route('/admin/nouveau_fichier', name: 'app_fichier_new', methods: ['GET'])]
    public function new(Request $request, FichierRepository $fichierRepository): Response
    {
        $user = $this->getUser();
        $fichier = new Fichier();
        $form = $this->createForm(FichierType::class, $fichier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichierRepository->save($fichier, true);

            return $this->redirectToRoute('app_fichier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fichier/new.html.twig', [
            'fichier' => $fichier,
            'form' => $form,
            'user'=>$user->getUserIdentifier(),
        ]);
    }

    #[Route('/{id}', name: 'app_fichier_show', methods: ['GET'])]
    public function show(Fichier $fichier): Response
    {
        $user=$this->getUser();
        return $this->render('fichier/show.html.twig', [
            'fichier' => $fichier,
            'user'=>$user->getUserIdentifier(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fichier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fichier $fichier, FichierRepository $fichierRepository): Response
    {
        $form = $this->createForm(FichierType::class, $fichier);
        $form->handleRequest($request);
        $user=$this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $fichierRepository->save($fichier, true);

            return $this->redirectToRoute('app_fichier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fichier/edit.html.twig', [
            'fichier' => $fichier,
            'form' => $form,
            'user'=>$user->getUserIdentifier()
        ]);
    }

    #[Route('/{id}', name: 'app_fichier_delete', methods: ['POST'])]
    public function delete(Request $request, Fichier $fichier, FichierRepository $fichierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fichier->getId(), $request->request->get('_token'))) {
            $fichierRepository->remove($fichier, true);
        }

        return $this->redirectToRoute('app_fichier_index', [], Response::HTTP_SEE_OTHER);
    }
}
