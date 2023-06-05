<?php

namespace App\Entity;

use App\Repository\FichierDemandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FichierDemandeRepository::class)]
class FichierDemande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
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
        return $this->nom_fichier;
    }

    public function setNomFichier(string $nom_fichier): self
    {
        $this->nom_fichier = $nom_fichier;

        return $this;
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

    public function __toString() {
        return $this->getNomFichier();
    }
}
