<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecoltesMielRepository")
 */
class RecoltesMiel
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
    private $dateRecolteMiel;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPotsRecolteMiel;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prixPotMiel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ruchers", inversedBy="recoltesMiels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rucher;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRecolteMiel(): ?\DateTimeInterface
    {
        return $this->dateRecolteMiel;
    }

    public function setDateRecolteMiel(\DateTimeInterface $dateRecolteMiel): self
    {
        $this->dateRecolteMiel = $dateRecolteMiel;

        return $this;
    }

    public function getNbPotsRecolteMiel(): ?int
    {
        return $this->nbPotsRecolteMiel;
    }

    public function setNbPotsRecolteMiel(int $nbPotsRecolteMiel): self
    {
        $this->nbPotsRecolteMiel = $nbPotsRecolteMiel;

        return $this;
    }

    public function getPrixPotMiel(): ?float
    {
        return $this->prixPotMiel;
    }

    public function setPrixPotMiel(?float $prixPotMiel): self
    {
        $this->prixPotMiel = $prixPotMiel;

        return $this;
    }

    public function getRucher(): ?Ruchers
    {
        return $this->rucher;
    }

    public function setRucher(?Ruchers $rucher): self
    {
        $this->rucher = $rucher;

        return $this;
    }
}
