<?php

namespace App\Controller;
use App\Entity\Fichier;
use App\Entity\InfoClient;
use App\Entity\User;
use App\Entity\FichierDemande;
use App\Form\FichierDemandeType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FichierDemandeRepository;
use App\Repository\FichierRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Component\HttpFoundation\File\File;

#[Route('fichier_demande')]
class FichierDemandeController extends AbstractController
{
    #[Route('/', name: 'app_fichier_demande_index', methods: ['GET'])]
    public function index(FichierDemandeRepository $fichierDemandeRepository): Response
    {
   
    
        $user = $this->getUser();
        $test = $fichierDemandeRepository->findAll();

        // dd($fichierDemandeRepository->findAll());
        return $this->render('fichier_demande/index.html.twig', [
            'fichier_demandes' =>   $fichierDemandeRepository->createQueryBuilder('fd')
            ->leftJoin('fd.id_user', 'u')
            ->leftJoin('fd.id_fichier', 'f')
            ->addSelect('u')
            ->addSelect('f')
            ->getQuery()
            ->getResult(),
            'user'=>$user->getUserIdentifier()
        ]);

    }

    #[Route('/new', name: 'app_fichier_demande_new', methods: ['GET', 'POST'])]
    public function new(EntityManagerInterface $entityManager ,Request $request, UserRepository $userrepo, FichierRepository $fichierrepo, FichierDemandeRepository $fichierDemandeRepository): Response
    {
        $user = $this->getUser();
        $fichierDemande = new FichierDemande();
        $form = $this->createForm(FichierDemandeType::class, $fichierDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('nom_fichier')->getData();
              // Il s'agit de l'id du comptable 
            $idUser = $form->get('id_user')->getData()->getId();
            $idUser = $userrepo->find($idUser);
           
            // dd($idUser);
               //Il s'agit de l'id du fichier demander pour tout les clients
            $idNomFichier= $form->get('id_fichier')->getData()->getId();
            $idNomFichier = $fichierrepo->find($idNomFichier);

            $nomOriginal = $form->get('nom_fichier')->getData()->getClientOriginalName();
            $destinationDirectory = $this->getParameter('kernel.project_dir') . '/public/fichier';
            // dd($destinationDirectory);
            $newFilename = $nomOriginal;
            // dd($newFilename);
            $uploadedFile->move($destinationDirectory, $newFilename);
            $fichierDemande->setNomFichier($destinationDirectory.$newFilename);
            $fichierDemande->setIdUser($idUser);
            $fichierDemande->setIdFichier($idNomFichier);
            $entityManager->persist($fichierDemande);
            $entityManager->flush();

            // dd($fichierDemande);
            // $fichierDemandeRepository->save($fichierDemande, true);

            return $this->redirectToRoute('app_fichier_demande_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('fichier_demande/new.html.twig', [
            'fichier_demande' => $fichierDemande,
            'form' => $form,
            'user'=>$user->getUserIdentifier()
        ]);
    }

    #[Route('/{id}', name: 'app_fichier_demande_show', methods: ['GET'])]
    public function show(FichierDemande $fichierDemande): Response
    {
        $user = $this->getUser();
        return $this->render('fichier_demande/show.html.twig', [
            'fichier_demande' => $fichierDemande,
            'user'=>$user->getUserIdentifier()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fichier_demande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FichierDemande $fichierDemande, FichierDemandeRepository $fichierDemandeRepository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(FichierDemandeType::class, $fichierDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichierDemandeRepository->save($fichierDemande, true);

            return $this->redirectToRoute('app_fichier_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fichier_demande/edit.html.twig', [
            'fichier_demande' => $fichierDemande,
            'form' => $form,
            'user'=>$user->getUserIdentifier()
        ]);
    }

    #[Route('/{id}', name: 'app_fichier_demande_delete', methods: ['POST'])]
    public function delete(Request $request, FichierDemande $fichierDemande, FichierDemandeRepository $fichierDemandeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fichierDemande->getId(), $request->request->get('_token'))) {
            $fichierDemandeRepository->remove($fichierDemande, true);
        }

        return $this->redirectToRoute('app_fichier_demande_index', [], Response::HTTP_SEE_OTHER);
    }
}
