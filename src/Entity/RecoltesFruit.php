<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecoltesFruitRepository")
 */
class RecoltesFruit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateRecolteFruit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomFruitRecolte;

    /**
     * @ORM\Column(type="float")
     */
    private $nbKgRecolteFruit;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prixKgFruit;


    /**
     * @ORM\ManyToOne(targetEntity=Activites::class, inversedBy="recoltesFruits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRecolteFruit(): ?\DateTimeInterface
    {
        return $this->dateRecolteFruit;
    }

    public function setDateRecolteFruit(?\DateTimeInterface $dateRecolteFruit): self
    {
        $this->dateRecolteFruit = $dateRecolteFruit;

        return $this;
    }

    public function getNomFruitRecolte(): ?string
    {
        return $this->nomFruitRecolte;
    }

    public function setNomFruitRecolte(string $nomFruitRecolte): self
    {
        $this->nomFruitRecolte = $nomFruitRecolte;

        return $this;
    }

    public function getNbKgRecolteFruit(): ?float
    {
        return $this->nbKgRecolteFruit;
    }

    public function setNbKgRecolteFruit(float $nbKgRecolteFruit): self
    {
        $this->nbKgRecolteFruit = $nbKgRecolteFruit;

        return $this;
    }

    public function getPrixKgFruit(): ?float
    {
        return $this->prixKgFruit;
    }

    public function setPrixKgFruit(?float $prixKgFruit): self
    {
        $this->prixKgFruit = $prixKgFruit;

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
