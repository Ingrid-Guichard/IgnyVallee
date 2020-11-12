<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecoltesLegumeRepository")
 */
class RecoltesLegume
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateRecolteLegume;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomLegumeRecolte;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $nbKgRecolteLegume;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prixLegume;

    /**
     * @ORM\ManyToOne(targetEntity=Activites::class, inversedBy="recoltesLegumes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRecolteLegume(): ?\DateTimeInterface
    {
        return $this->dateRecolteLegume;
    }

    public function setDateRecolteLegume(\DateTimeInterface $dateRecolteLegume): self
    {
        $this->dateRecolteLegume = $dateRecolteLegume;

        return $this;
    }

    public function getNomLegumeRecolte(): ?string
    {
        return $this->nomLegumeRecolte;
    }

    public function setNomLegumeRecolte(string $nomLegumeRecolte): self
    {
        $this->nomLegumeRecolte = $nomLegumeRecolte;

        return $this;
    }

    public function getNbKgRecolteLegume(): ?float
    {
        return $this->nbKgRecolteLegume;
    }

    public function setNbKgRecolteLegume(?float $nbKgRecolteLegume): self
    {
        $this->nbKgRecolteLegume = $nbKgRecolteLegume;

        return $this;
    }

    public function getPrixLegume(): ?float
    {
        return $this->prixLegume;
    }

    public function setPrixLegume(?float $prixLegume): self
    {
        $this->prixLegume = $prixLegume;

        return $this;
    }

    public function getActivite(): ?Activites
    {
        return $this->activite;
    }

    public function setActivite(?Activites $activite): self
    {
        $this->activite = $activite;

        return $this;
    }
}
