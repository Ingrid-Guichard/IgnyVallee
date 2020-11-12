<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RuchesRepository")
 */
class Ruches
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
    private $nomRuche;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modeleRuche;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $plancherRuche;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emplacementRuche;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $couvreCadreRuche;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $toitRuche;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateInstallationRuche;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $origineColonie;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateInstallationColonie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $especeColonie;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $naissanceReine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nourrisseurs;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $muselieres;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ruchers", inversedBy="ruches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rucher;

    /**
     * @ORM\OneToMany(targetEntity=FichesDeVisite::class, mappedBy="ruche", orphanRemoval=true)
     */
    private $fichesDeVisites;

    public function __construct()
    {
        $this->fichesDeVisites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRuche(): ?string
    {
        return $this->nomRuche;
    }

    public function setNomRuche(string $nomRuche): self
    {
        $this->nomRuche = $nomRuche;

        return $this;
    }

    public function getModeleRuche(): ?string
    {
        return $this->modeleRuche;
    }

    public function setModeleRuche(string $modeleRuche): self
    {
        $this->modeleRuche = $modeleRuche;

        return $this;
    }

    public function getPlancherRuche(): ?string
    {
        return $this->plancherRuche;
    }

    public function setPlancherRuche(string $plancherRuche): self
    {
        $this->plancherRuche = $plancherRuche;

        return $this;
    }

    public function getEmplacementRuche(): ?string
    {
        return $this->emplacementRuche;
    }

    public function setEmplacementRuche(?string $emplacementRuche): self
    {
        $this->emplacementRuche = $emplacementRuche;

        return $this;
    }

    public function getCouvreCadreRuche(): ?string
    {
        return $this->couvreCadreRuche;
    }

    public function setCouvreCadreRuche(string $couvreCadreRuche): self
    {
        $this->couvreCadreRuche = $couvreCadreRuche;

        return $this;
    }

    public function getToitRuche(): ?string
    {
        return $this->toitRuche;
    }

    public function setToitRuche(string $toitRuche): self
    {
        $this->toitRuche = $toitRuche;

        return $this;
    }

    public function getDateInstallationRuche(): ?\DateTimeInterface
    {
        return $this->dateInstallationRuche;
    }

    public function setDateInstallationRuche(?\DateTimeInterface $dateInstallationRuche): self
    {
        $this->dateInstallationRuche = $dateInstallationRuche;

        return $this;
    }

    public function getOrigineColonie(): ?string
    {
        return $this->origineColonie;
    }

    public function setOrigineColonie(?string $origineColonie): self
    {
        $this->origineColonie = $origineColonie;

        return $this;
    }

    public function getDateInstallationColonie(): ?\DateTimeInterface
    {
        return $this->dateInstallationColonie;
    }

    public function setDateInstallationColonie(?\DateTimeInterface $dateInstallationColonie): self
    {
        $this->dateInstallationColonie = $dateInstallationColonie;

        return $this;
    }

    public function getEspeceColonie(): ?string
    {
        return $this->especeColonie;
    }

    public function setEspeceColonie(?string $especeColonie): self
    {
        $this->especeColonie = $especeColonie;

        return $this;
    }

    public function getNaissanceReine(): ?\DateTimeInterface
    {
        return $this->naissanceReine;
    }

    public function setNaissanceReine(?\DateTimeInterface $naissanceReine): self
    {
        $this->naissanceReine = $naissanceReine;

        return $this;
    }

    public function getNourrisseurs(): ?string
    {
        return $this->nourrisseurs;
    }

    public function setNourrisseurs(?string $nourrisseurs): self
    {
        $this->nourrisseurs = $nourrisseurs;

        return $this;
    }

    public function getMuselieres(): ?bool
    {
        return $this->muselieres;
    }

    public function setMuselieres(?bool $muselieres): self
    {
        $this->muselieres = $muselieres;

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

    /**
     * @return Collection|FichesDeVisite[]
     */
    public function getFichesDeVisites(): Collection
    {
        return $this->fichesDeVisites;
    }

    public function addFichesDeVisite(FichesDeVisite $fichesDeVisite): self
    {
        if (!$this->fichesDeVisites->contains($fichesDeVisite)) {
            $this->fichesDeVisites[] = $fichesDeVisite;
            $fichesDeVisite->setRuche($this);
        }

        return $this;
    }

    public function removeFichesDeVisite(FichesDeVisite $fichesDeVisite): self
    {
        if ($this->fichesDeVisites->contains($fichesDeVisite)) {
            $this->fichesDeVisites->removeElement($fichesDeVisite);
            // set the owning side to null (unless already changed)
            if ($fichesDeVisite->getRuche() === $this) {
                $fichesDeVisite->setRuche(null);
            }
        }

        return $this;
    }


}
