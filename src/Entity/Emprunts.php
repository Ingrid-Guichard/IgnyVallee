<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmpruntsRepository")
 */
class Emprunts
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
    private $dateDebut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbExemplaires;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Outils", inversedBy="emprunts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $outil;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Adherents", inversedBy="emprunts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adherent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getNbExemplaires(): ?int
    {
        return $this->nbExemplaires;
    }

    public function setNbExemplaires(int $nbExemplaires): self
    {
        $this->nbExemplaires = $nbExemplaires;

        return $this;
    }

    public function getOutil(): ?Outils
    {
        return $this->outil;
    }

    public function setOutil(?Outils $outil): self
    {
        $this->outil = $outil;

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
}
