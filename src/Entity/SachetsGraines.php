<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SachetsGrainesRepository")
 */
class SachetsGraines
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
    private $nomGraines;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbGraines;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $saisonPlantationGraines;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $qualiteGraines;

    /**
     * @ORM\ManyToOne(targetEntity=Activites::class, inversedBy="sachetsGraines")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomGraines(): ?string
    {
        return $this->nomGraines;
    }

    public function setNomGraines(string $nomGraines): self
    {
        $this->nomGraines = $nomGraines;

        return $this;
    }

    public function getNbGraines(): ?int
    {
        return $this->nbGraines;
    }

    public function setNbGraines(int $nbGraines): self
    {
        $this->nbGraines = $nbGraines;

        return $this;
    }

    public function getSaisonPlantationGraines(): ?string
    {
        return $this->saisonPlantationGraines;
    }

    public function setSaisonPlantationGraines(?string $saisonPlantationGraines): self
    {
        $this->saisonPlantationGraines = $saisonPlantationGraines;

        return $this;
    }

    public function getQualiteGraines(): ?string
    {
        return $this->qualiteGraines;
    }

    public function setQualiteGraines(?string $qualiteGraines): self
    {
        $this->qualiteGraines = $qualiteGraines;

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
