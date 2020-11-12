<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CotisationsRepository")
 */
class Cotisations
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
    private $debutCotisation;

    /**
     * @ORM\Column(type="date")
     */
    private $finCotisation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typePaiement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Adherents", inversedBy="cotisations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adherent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeAdhesion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebutCotisation(): ?\DateTimeInterface
    {
        return $this->debutCotisation;
    }

    public function setDebutCotisation(\DateTimeInterface $debutCotisation): self
    {
        $this->debutCotisation = $debutCotisation;

        return $this;
    }

    public function getFinCotisation(): ?\DateTimeInterface
    {
        return $this->finCotisation;
    }

    public function setFinCotisation(\DateTimeInterface $finCotisation): self
    {
        $this->finCotisation = $finCotisation;

        return $this;
    }

    public function getTypePaiement(): ?string
    {
        return $this->typePaiement;
    }

    public function setTypePaiement(string $typePaiement): self
    {
        $this->typePaiement = $typePaiement;

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

    public function getTypeAdhesion(): ?string
    {
        return $this->typeAdhesion;
    }

    public function setTypeAdhesion(?string $typeAdhesion): self
    {
        $this->typeAdhesion = $typeAdhesion;

        return $this;
    }
}
