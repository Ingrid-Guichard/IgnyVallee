<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivitesRepository")
 */
class Activites
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Referents", mappedBy="activites")
     */
    private $referents;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ateliers", mappedBy="activite", orphanRemoval=true)
     */
    private $ateliers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Adherents", mappedBy="activites")
     */
    private $adherents;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Arbres::class, mappedBy="activite", orphanRemoval=true)
     */
    private $arbres;

    /**
     * @ORM\OneToMany(targetEntity=RecoltesFruit::class, mappedBy="activite", orphanRemoval=true)
     */
    private $recoltesFruits;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=SachetsGraines::class, mappedBy="activite", orphanRemoval=true)
     */
    private $sachetsGraines;

    /**
     * @ORM\OneToMany(targetEntity=Parcelles::class, mappedBy="activite", orphanRemoval=true)
     */
    private $parcelles;

    /**
     * @ORM\OneToMany(targetEntity=RecoltesLegume::class, mappedBy="activite", orphanRemoval=true)
     */
    private $recoltesLegumes;

    /**
     * @ORM\OneToMany(targetEntity=Ruchers::class, mappedBy="activite", orphanRemoval=true)
     */
    private $ruchers;

    public function __construct()
    {
        $this->referents = new ArrayCollection();
        $this->ateliers = new ArrayCollection();
        $this->adherents = new ArrayCollection();
        $this->arbres = new ArrayCollection();
        $this->recoltesFruits = new ArrayCollection();
        $this->sachetsGraines = new ArrayCollection();
        $this->parcelles = new ArrayCollection();
        $this->recoltesLegumes = new ArrayCollection();
        $this->ruchers = new ArrayCollection();
        $this->taches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $referent->addActivite($this);
        }

        return $this;
    }

    public function removeReferent(Referents $referent): self
    {
        if ($this->referents->contains($referent)) {
            $this->referents->removeElement($referent);
            $referent->removeActivite($this);
        }

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
            $atelier->setActivite($this);
        }

        return $this;
    }

    public function removeAtelier(Ateliers $atelier): self
    {
        if ($this->ateliers->contains($atelier)) {
            $this->ateliers->removeElement($atelier);
            // set the owning side to null (unless already changed)
            if ($atelier->getActivite() === $this) {
                $atelier->setActivite(null);
            }
        }

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
            $adherent->addActivite($this);
        }

        return $this;
    }

    public function removeAdherent(Adherents $adherent): self
    {
        if ($this->adherents->contains($adherent)) {
            $this->adherents->removeElement($adherent);
            $adherent->removeActivite($this);
        }

        return $this;
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

    /**
     * @return Collection|Arbres[]
     */
    public function getArbres(): Collection
    {
        return $this->arbres;
    }

    public function addArbre(Arbres $arbre): self
    {
        if (!$this->arbres->contains($arbre)) {
            $this->arbres[] = $arbre;
            $arbre->setActivite($this);
        }

        return $this;
    }

    public function removeArbre(Arbres $arbre): self
    {
        if ($this->arbres->contains($arbre)) {
            $this->arbres->removeElement($arbre);
            // set the owning side to null (unless already changed)
            if ($arbre->getActivite() === $this) {
                $arbre->setActivite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RecoltesFruit[]
     */
    public function getRecoltesFruits(): Collection
    {
        return $this->recoltesFruits;
    }

    public function addRecoltesFruit(RecoltesFruit $recoltesFruit): self
    {
        if (!$this->recoltesFruits->contains($recoltesFruit)) {
            $this->recoltesFruits[] = $recoltesFruit;
            $recoltesFruit->setActivite($this);
        }

        return $this;
    }

    public function removeRecoltesFruit(RecoltesFruit $recoltesFruit): self
    {
        if ($this->recoltesFruits->contains($recoltesFruit)) {
            $this->recoltesFruits->removeElement($recoltesFruit);
            // set the owning side to null (unless already changed)
            if ($recoltesFruit->getActivite() === $this) {
                $recoltesFruit->setActivite(null);
            }
        }

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

    /**
     * @return Collection|SachetsGraines[]
     */
    public function getSachetsGraines(): Collection
    {
        return $this->sachetsGraines;
    }

    public function addSachetsGraine(SachetsGraines $sachetsGraine): self
    {
        if (!$this->sachetsGraines->contains($sachetsGraine)) {
            $this->sachetsGraines[] = $sachetsGraine;
            $sachetsGraine->setActivite($this);
        }

        return $this;
    }

    public function removeSachetsGraine(SachetsGraines $sachetsGraine): self
    {
        if ($this->sachetsGraines->contains($sachetsGraine)) {
            $this->sachetsGraines->removeElement($sachetsGraine);
            // set the owning side to null (unless already changed)
            if ($sachetsGraine->getActivite() === $this) {
                $sachetsGraine->setActivite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Parcelles[]
     */
    public function getParcelles(): Collection
    {
        return $this->parcelles;
    }

    public function addParcelle(Parcelles $parcelle): self
    {
        if (!$this->parcelles->contains($parcelle)) {
            $this->parcelles[] = $parcelle;
            $parcelle->setActivite($this);
        }

        return $this;
    }

    public function removeParcelle(Parcelles $parcelle): self
    {
        if ($this->parcelles->contains($parcelle)) {
            $this->parcelles->removeElement($parcelle);
            // set the owning side to null (unless already changed)
            if ($parcelle->getActivite() === $this) {
                $parcelle->setActivite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RecoltesLegume[]
     */
    public function getRecoltesLegumes(): Collection
    {
        return $this->recoltesLegumes;
    }

    public function addRecoltesLegume(RecoltesLegume $recoltesLegume): self
    {
        if (!$this->recoltesLegumes->contains($recoltesLegume)) {
            $this->recoltesLegumes[] = $recoltesLegume;
            $recoltesLegume->setActivite($this);
        }

        return $this;
    }

    public function removeRecoltesLegume(RecoltesLegume $recoltesLegume): self
    {
        if ($this->recoltesLegumes->contains($recoltesLegume)) {
            $this->recoltesLegumes->removeElement($recoltesLegume);
            // set the owning side to null (unless already changed)
            if ($recoltesLegume->getActivite() === $this) {
                $recoltesLegume->setActivite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ruchers[]
     */
    public function getRuchers(): Collection
    {
        return $this->ruchers;
    }

    public function addRucher(Ruchers $rucher): self
    {
        if (!$this->ruchers->contains($rucher)) {
            $this->ruchers[] = $rucher;
            $rucher->setActivite($this);
        }

        return $this;
    }

    public function removeRucher(Ruchers $rucher): self
    {
        if ($this->ruchers->contains($rucher)) {
            $this->ruchers->removeElement($rucher);
            // set the owning side to null (unless already changed)
            if ($rucher->getActivite() === $this) {
                $rucher->setActivite(null);
            }
        }

        return $this;
    }
}
