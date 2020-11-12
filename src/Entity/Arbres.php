<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArbresRepository")
 */
class Arbres
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomFruitArbre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $EtatArbre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ageArbre;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fructificationArbre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Adherents", inversedBy="arbres")
     */
    private $adherent;

    /**
     * @ORM\ManyToOne(targetEntity=Activites::class, inversedBy="arbres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activite;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroArbre;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $parrainageValide;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFruitArbre(): ?string
    {
        return $this->nomFruitArbre;
    }

    public function setNomFruitArbre(string $nomFruitArbre): self
    {
        $this->nomFruitArbre = $nomFruitArbre;

        return $this;
    }

    public function getEtatArbre(): ?string
    {
        return $this->EtatArbre;
    }

    public function setEtatArbre(?string $EtatArbre): self
    {
        $this->EtatArbre = $EtatArbre;

        return $this;
    }

    public function getAgeArbre(): ?int
    {
        return $this->ageArbre;
    }

    public function setAgeArbre(?int $ageArbre): self
    {
        $this->ageArbre = $ageArbre;

        return $this;
    }

    public function getFructificationArbre(): ?bool
    {
        return $this->fructificationArbre;
    }

    public function setFructificationArbre(?bool $fructificationArbre): self
    {
        $this->fructificationArbre = $fructificationArbre;

        return $this;
    }

    public function getAdherent(): ?Adherents
    {
        return $this->adherent;
    }

    public function setAdherent(?Adherents $adherent): self
    {
        $this->adherent = $adherent;

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

    public function getNumeroArbre(): ?int
    {
        return $this->numeroArbre;
    }

    public function setNumeroArbre(int $numeroArbre): self
    {
        $this->numeroArbre = $numeroArbre;

        return $this;
    }

    public function getParrainageValide(): ?bool
    {
        return $this->parrainageValide;
    }

    public function setParrainageValide(?bool $parrainageValide): self
    {
        $this->parrainageValide = $parrainageValide;

        return $this;
    }
}
