<?php

namespace App\Entity;

use App\Repository\FichierDemandeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: FichierDemandeRepository::class)]
#[Vich\Uploadable]
class FichierDemande
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?string $nom_fichier = null;


    #[ORM\ManyToOne(inversedBy: 'fichierDemandes')]
    private ?User $id_user = null;

    #[ORM\ManyToOne(inversedBy: 'fichierDemandes')]
    private ?Fichier $id_fichier = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFichier(): ?string
    {
        return $this->nom_fichier ;
    }


    public function setNomFichier(?string $nomFichier): void
    {
        $this->nom_fichier = $nomFichier;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdFichier(): ?Fichier
    {
        return $this->id_fichier;
    }

    public function setIdFichier(?Fichier $id_fichier): self
    {
        $this->id_fichier = $id_fichier;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNomFichier() ?? '';
        }

}
