<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RuchersRepository")
 */
class Ruchers
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
    private $nomRucher;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descriptionRucher;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $lieuRucher;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $partenaireRucher;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateCreationRucher;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecoltesMiel", mappedBy="rucher", orphanRemoval=true)
     */
    private $recoltesMiels;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ruches", mappedBy="rucher", orphanRemoval=true)
     */
    private $ruches;

    /**
     * @ORM\ManyToOne(targetEntity=Activites::class, inversedBy="ruchers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activite;

    public function __construct()
    {
        $this->recoltesMiels = new ArrayCollection();
        $this->fichesDeVisites = new ArrayCollection();
        $this->ruches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRucher(): ?string
    {
        return $this->nomRucher;
    }

    public function setNomRucher(string $nomRucher): self
    {
        $this->nomRucher = $nomRucher;

        return $this;
    }

    public function getDescriptionRucher(): ?string
    {
        return $this->descriptionRucher;
    }

    public function setDescriptionRucher(?string $descriptionRucher): self
    {
        $this->descriptionRucher = $descriptionRucher;

        return $this;
    }

    public function getLieuRucher(): ?string
    {
        return $this->lieuRucher;
    }

    public function setLieuRucher(?string $lieuRucher): self
    {
        $this->lieuRucher = $lieuRucher;

        return $this;
    }

    public function getPartenaireRucher(): ?string
    {
        return $this->partenaireRucher;
    }

    public function setPartenaireRucher(?string $partenaireRucher): self
    {
        $this->partenaireRucher = $partenaireRucher;

        return $this;
    }

    public function getDateCreationRucher(): ?\DateTimeInterface
    {
        return $this->dateCreationRucher;
    }

    public function setDateCreationRucher(?\DateTimeInterface $dateCreationRucher): self
    {
        $this->dateCreationRucher = $dateCreationRucher;

        return $this;
    }

    /**
     * @return Collection|RecoltesMiel[]
     */
    public function getRecoltesMiels(): Collection
    {
        return $this->recoltesMiels;
    }

    public function addRecoltesMiel(RecoltesMiel $recoltesMiel): self
    {
        if (!$this->recoltesMiels->contains($recoltesMiel)) {
            $this->recoltesMiels[] = $recoltesMiel;
            $recoltesMiel->setRucher($this);
        }

        return $this;
    }

    public function removeRecoltesMiel(RecoltesMiel $recoltesMiel): self
    {
        if ($this->recoltesMiels->contains($recoltesMiel)) {
            $this->recoltesMiels->removeElement($recoltesMiel);
            // set the owning side to null (unless already changed)
            if ($recoltesMiel->getRucher() === $this) {
                $recoltesMiel->setRucher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ruches[]
     */
    public function getRuches(): Collection
    {
        return $this->ruches;
    }

    public function addRuch(Ruches $ruch): self
    {
        if (!$this->ruches->contains($ruch)) {
            $this->ruches[] = $ruch;
            $ruch->setRucher($this);
        }

        return $this;
    }

    public function removeRuch(Ruches $ruch): self
    {
        if ($this->ruches->contains($ruch)) {
            $this->ruches->removeElement($ruch);
            // set the owning side to null (unless already changed)
            if ($ruch->getRucher() === $this) {
                $ruch->setRucher(null);
            }
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
}
