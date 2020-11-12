<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AteliersRepository")
 */
class Ateliers
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
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $heuresGestionAtelier;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Adherents", mappedBy="ateliers")
     */
    private $adherents;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Referents", inversedBy="ateliers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $referents;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activites", inversedBy="ateliers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activite;

    /**
     * @ORM\ManyToMany(targetEntity=Taches::class, inversedBy="ateliers")
     */
    private $taches;

    public function __construct()
    {
        $this->adherents = new ArrayCollection();
        $this->taches = new ArrayCollection();
        $this->referents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
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

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getHeuresGestionAtelier(): ?int
    {
        return $this->heuresGestionAtelier;
    }

    public function setHeuresGestionAtelier(int $heuresGestionAtelier): self
    {
        $this->heuresGestionAtelier = $heuresGestionAtelier;

        return $this;
    }

    /**
     * @return Collection|Adherents[]
     */
    public function getAdherents(): Collection
    {
        return $this->adherents;
    }

    public function addAdherent(Adherents $adherent): self
    {
        if (!$this->adherents->contains($adherent)) {
            $this->adherents[] = $adherent;
            $adherent->addAtelier($this);
        }

        return $this;
    }

    public function removeAdherent(Adherents $adherent): self
    {
        if ($this->adherents->contains($adherent)) {
            $this->adherents->removeElement($adherent);
            $adherent->removeAtelier($this);
        }

        return $this;
    }


    /**
     * @return Collection|Referents[]
     */
    public function getReferents(): Collection
    {
        return $this->referents;
    }

    public function addReferent(Referents $referent): self
    {
        if (!$this->referents->contains($referent)) {
            $this->referents[] = $referent;
        }

        return $this;
    }

    public function removeReferent(Referents $referent): self
    {
        if ($this->referents->contains($referent)) {
            $this->referents->removeElement($referent);
        }

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

    /**
     * @return Collection|Taches[]
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Taches $tach): self
    {
        if (!$this->taches->contains($tach)) {
            $this->taches[] = $tach;
        }

        return $this;
    }

    public function removeTach(Taches $tach): self
    {
        if ($this->taches->contains($tach)) {
            $this->taches->removeElement($tach);
        }

        return $this;
    }
}
