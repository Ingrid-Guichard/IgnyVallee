<?php

namespace App\Entity;

use App\Repository\FichesDeVisiteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FichesDeVisiteRepository::class)
 */
class FichesDeVisite
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
    private $dateVisite;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $objectifs;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observations;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $poidsRuche;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tauxAgressiviteAbeilles;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cadre1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cadre2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cadre3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cadre4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cadre5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cadre6;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cadre7;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cadre8;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cadre9;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cadre10;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeStructure1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeStructure2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeStructure3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeStructure4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeStructure5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeStructure6;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeStructure7;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeStructure8;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeStructure9;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeStructure10;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $calculVarroa;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeVisite;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantiteAbeilles;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detectionReine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nourrissement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeSirop;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tempsVisite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cellulesRoyales;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $typeCouvain = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reserveMiel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reservePollen;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $nbCadresCouvain;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $nbCadresMiel;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $nbCadresPollen;

    /**
     * @ORM\ManyToOne(targetEntity=Adherents::class, inversedBy="fichesDeVisites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adherent;

    /**
     * @ORM\ManyToOne(targetEntity=Ruches::class, inversedBy="fichesDeVisites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ruche;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVisite(): ?\DateTimeInterface
    {
        return $this->dateVisite;
    }

    public function setDateVisite(?\DateTimeInterface $dateVisite): self
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    public function getObjectifs(): ?string
    {
        return $this->objectifs;
    }

    public function setObjectifs(?string $objectifs): self
    {
        $this->objectifs = $objectifs;

        return $this;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): self
    {
        $this->observations = $observations;

        return $this;
    }

    public function getPoidsRuche(): ?float
    {
        return $this->poidsRuche;
    }

    public function setPoidsRuche(?float $poidsRuche): self
    {
        $this->poidsRuche = $poidsRuche;

        return $this;
    }

    public function getTauxAgressiviteAbeilles(): ?int
    {
        return $this->tauxAgressiviteAbeilles;
    }

    public function setTauxAgressiviteAbeilles(?int $tauxAgressiviteAbeilles): self
    {
        $this->tauxAgressiviteAbeilles = $tauxAgressiviteAbeilles;

        return $this;
    }

    public function getCadre1(): ?string
    {
        return $this->cadre1;
    }

    public function setCadre1(?string $cadre1): self
    {
        $this->cadre1 = $cadre1;

        return $this;
    }

    public function getCadre2(): ?string
    {
        return $this->cadre2;
    }

    public function setCadre2(?string $cadre2): self
    {
        $this->cadre2 = $cadre2;

        return $this;
    }

    public function getCadre3(): ?string
    {
        return $this->cadre3;
    }

    public function setCadre3(?string $cadre3): self
    {
        $this->cadre3 = $cadre3;

        return $this;
    }

    public function getCadre4(): ?string
    {
        return $this->cadre4;
    }

    public function setCadre4(?string $cadre4): self
    {
        $this->cadre4 = $cadre4;

        return $this;
    }

    public function getCadre5(): ?string
    {
        return $this->cadre5;
    }

    public function setCadre5(?string $cadre5): self
    {
        $this->cadre5 = $cadre5;

        return $this;
    }

    public function getCadre6(): ?string
    {
        return $this->cadre6;
    }

    public function setCadre6(?string $cadre6): self
    {
        $this->cadre6 = $cadre6;

        return $this;
    }

    public function getCadre7(): ?string
    {
        return $this->cadre7;
    }

    public function setCadre7(?string $cadre7): self
    {
        $this->cadre7 = $cadre7;

        return $this;
    }

    public function getCadre8(): ?string
    {
        return $this->cadre8;
    }

    public function setCadre8(?string $cadre8): self
    {
        $this->cadre8 = $cadre8;

        return $this;
    }

    public function getCadre9(): ?string
    {
        return $this->cadre9;
    }

    public function setCadre9(?string $cadre9): self
    {
        $this->cadre9 = $cadre9;

        return $this;
    }

    public function getCadre10(): ?string
    {
        return $this->cadre10;
    }

    public function setCadre10(?string $cadre10): self
    {
        $this->cadre10 = $cadre10;

        return $this;
    }

    public function getTypeStructure1(): ?string
    {
        return $this->typeStructure1;
    }

    public function setTypeStructure1(?string $typeStructure1): self
    {
        $this->typeStructure1 = $typeStructure1;

        return $this;
    }

    public function getTypeStructure2(): ?string
    {
        return $this->typeStructure2;
    }

    public function setTypeStructure2(?string $typeStructure2): self
    {
        $this->typeStructure2 = $typeStructure2;

        return $this;
    }

    public function getTypeStructure3(): ?string
    {
        return $this->typeStructure3;
    }

    public function setTypeStructure3(?string $typeStructure3): self
    {
        $this->typeStructure3 = $typeStructure3;

        return $this;
    }

    public function getTypeStructure4(): ?string
    {
        return $this->typeStructure4;
    }

    public function setTypeStructure4(?string $typeStructure4): self
    {
        $this->typeStructure4 = $typeStructure4;

        return $this;
    }

    public function getTypeStructure5(): ?string
    {
        return $this->typeStructure5;
    }

    public function setTypeStructure5(?string $typeStructure5): self
    {
        $this->typeStructure5 = $typeStructure5;

        return $this;
    }

    public function getTypeStructure6(): ?string
    {
        return $this->typeStructure6;
    }

    public function setTypeStructure6(?string $typeStructure6): self
    {
        $this->typeStructure6 = $typeStructure6;

        return $this;
    }

    public function getTypeStructure7(): ?string
    {
        return $this->typeStructure7;
    }

    public function setTypeStructure7(?string $typeStructure7): self
    {
        $this->typeStructure7 = $typeStructure7;

        return $this;
    }

    public function getTypeStructure8(): ?string
    {
        return $this->typeStructure8;
    }

    public function setTypeStructure8(?string $typeStructure8): self
    {
        $this->typeStructure8 = $typeStructure8;

        return $this;
    }

    public function getTypeStructure9(): ?string
    {
        return $this->typeStructure9;
    }

    public function setTypeStructure9(?string $typeStructure9): self
    {
        $this->typeStructure9 = $typeStructure9;

        return $this;
    }

    public function getTypeStructure10(): ?string
    {
        return $this->typeStructure10;
    }

    public function setTypeStructure10(?string $typeStructure10): self
    {
        $this->typeStructure10 = $typeStructure10;

        return $this;
    }

    public function getCalculVarroa(): ?float
    {
        return $this->calculVarroa;
    }

    public function setCalculVarroa(?float $calculVarroa): self
    {
        $this->calculVarroa = $calculVarroa;

        return $this;
    }

    public function getTypeVisite(): ?string
    {
        return $this->typeVisite;
    }

    public function setTypeVisite(?string $typeVisite): self
    {
        $this->typeVisite = $typeVisite;

        return $this;
    }

    public function getQuantiteAbeilles(): ?int
    {
        return $this->quantiteAbeilles;
    }

    public function setQuantiteAbeilles(?int $quantiteAbeilles): self
    {
        $this->quantiteAbeilles = $quantiteAbeilles;

        return $this;
    }

    public function getDetectionReine(): ?string
    {
        return $this->detectionReine;
    }

    public function setDetectionReine(?string $detectionReine): self
    {
        $this->detectionReine = $detectionReine;

        return $this;
    }

    public function getNourrissement(): ?string
    {
        return $this->nourrissement;
    }

    public function setNourrissement(?string $nourrissement): self
    {
        $this->nourrissement = $nourrissement;

        return $this;
    }

    public function getTypeSirop(): ?string
    {
        return $this->typeSirop;
    }

    public function setTypeSirop(?string $typeSirop): self
    {
        $this->typeSirop = $typeSirop;

        return $this;
    }

    public function getTempsVisite(): ?int
    {
        return $this->tempsVisite;
    }

    public function setTempsVisite(?int $tempsVisite): self
    {
        $this->tempsVisite = $tempsVisite;

        return $this;
    }

    public function getCellulesRoyales(): ?string
    {
        return $this->cellulesRoyales;
    }

    public function setCellulesRoyales(?string $cellulesRoyales): self
    {
        $this->cellulesRoyales = $cellulesRoyales;

        return $this;
    }

    public function getTypeCouvain(): ?array
    {
        return $this->typeCouvain;
    }

    public function setTypeCouvain(?array $typeCouvain): self
    {
        $this->typeCouvain = $typeCouvain;

        return $this;
    }

    public function getReserveMiel(): ?string
    {
        return $this->reserveMiel;
    }

    public function setReserveMiel(?string $reserveMiel): self
    {
        $this->reserveMiel = $reserveMiel;

        return $this;
    }

    public function getReservePollen(): ?string
    {
        return $this->reservePollen;
    }

    public function setReservePollen(?string $reservePollen): self
    {
        $this->reservePollen = $reservePollen;

        return $this;
    }

    public function getNbCadresCouvain(): ?float
    {
        return $this->nbCadresCouvain;
    }

    public function setNbCadresCouvain(?float $nbCadresCouvain): self
    {
        $this->nbCadresCouvain = $nbCadresCouvain;

        return $this;
    }

    public function getNbCadresMiel(): ?float
    {
        return $this->nbCadresMiel;
    }

    public function setNbCadresMiel(?float $nbCadresMiel): self
    {
        $this->nbCadresMiel = $nbCadresMiel;

        return $this;
    }

    public function getNbCadresPollen(): ?float
    {
        return $this->nbCadresPollen;
    }

    public function setNbCadresPollen(?float $nbCadresPollen): self
    {
        $this->nbCadresPollen = $nbCadresPollen;

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

    public function getRuche(): ?Ruches
    {
        return $this->ruche;
    }

    public function setRuche(?Ruches $ruche): self
    {
        $this->ruche = $ruche;

        return $this;
    }
}
