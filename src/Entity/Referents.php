<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReferentsRepository")
 */
class Referents
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $heuresGestionReferent;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Ateliers", mappedBy="referents")
     */
    private $ateliers;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Adherents", inversedBy="referent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adherent;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Activites", inversedBy="referents")
     * 
     */
    private $activites;

    public function __construct()
    {
        $this->ateliers = new ArrayCollection();
        $this->activites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeuresGestionReferent(): ?int
    {
        return $this->heuresGestionReferent;
    }

    public function setHeuresGestionReferent(int $heuresGestionReferent): self
    {
        $this->heuresGestionReferent = $heuresGestionReferent;

        return $this;
    }

    public function addHeuresGestionReferent(int $heuresGestionReferent): self
    {
        $this->heuresGestionReferent += $heuresGestionReferent;

        return $this;
    }

    /**
     * @return Collection|Ateliers[]
     */
    public function getAteliers(): Collection
    {
        return $this->ateliers;
    }

    public function addAtelier(Ateliers $atelier): self
    {
        if (!$this->ateliers->contains($atelier)) {
            $this->ateliers[] = $atelier;
            $atelier->addReferent($this);
        }

        return $this;
    }

    public function removeAtelier(Ateliers $atelier): self
    {
        if ($this->ateliers->contains($atelier)) {
            $this->ateliers->removeElement($atelier);
            $atelier->removeReferent($this);
        }

        return $this;
    }

    public function getAdherent(): ?Adherents
    {
        return $this->adherent;
    }

    public function setAdherent(Adherents $adherent): self
    {
        $this->adherent = $adherent;

        return $this;
    }

    /**
     * @return Collection|Activites[]
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activites $activite): self
    {
        if (!$this->activites->contains($activite)) {
            $this->activites[] = $activite;
        }

        return $this;
    }

    public function removeActivite(Activites $activite): self
    {
        if ($this->activites->contains($activite)) {
            $this->activites->removeElement($activite);
        }

        return $this;
    }
}
