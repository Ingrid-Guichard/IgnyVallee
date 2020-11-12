<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParcellesRepository")
 */
class Parcelles
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
    private $colonneParcelle;

    /**
     * @ORM\Column(type="integer")
     */
    private $ligneParcelle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $newParcelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etatTerreParcelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $plantationParcelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $historique1PlantationParcelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $historique2PlantationParcelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $historique3PlantationParcelle;

    /**
     * @ORM\ManyToOne(targetEntity=Activites::class, inversedBy="parcelles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColonneParcelle(): ?int
    {
        return $this->colonneParcelle;
    }

    public function setColonneParcelle(int $colonneParcelle): self
    {
        $this->colonneParcelle = $colonneParcelle;

        return $this;
    }

    public function getLigneParcelle(): ?int
    {
        return $this->ligneParcelle;
    }

    public function setLigneParcelle(int $ligneParcelle): self
    {
        $this->ligneParcelle = $ligneParcelle;

        return $this;
    }

    public function getNewParcelle(): ?bool
    {
        return $this->newParcelle;
    }

    public function setNewParcelle(bool $newParcelle): self
    {
        $this->newParcelle = $newParcelle;

        return $this;
    }

    public function getEtatTerreParcelle(): ?string
    {
        return $this->etatTerreParcelle;
    }

    public function setEtatTerreParcelle(?string $etatTerreParcelle): self
    {
        $this->etatTerreParcelle = $etatTerreParcelle;

        return $this;
    }

    public function getPlantationParcelle(): ?string
    {
        return $this->plantationParcelle;
    }

    public function setPlantationParcelle(?string $plantationParcelle): self
    {
        $this->plantationParcelle = $plantationParcelle;

        return $this;
    }

    public function getHistorique1PlantationParcelle(): ?string
    {
        return $this->historique1PlantationParcelle;
    }

    public function setHistorique1PlantationParcelle(?string $historique1PlantationParcelle): self
    {
        $this->historique1PlantationParcelle = $historique1PlantationParcelle;

        return $this;
    }

    public function getHistorique2PlantationParcelle(): ?string
    {
        return $this->historique2PlantationParcelle;
    }

    public function setHistorique2PlantationParcelle(?string $historique2PlantationParcelle): self
    {
        $this->historique2PlantationParcelle = $historique2PlantationParcelle;

        return $this;
    }

    public function getHistorique3PlantationParcelle(): ?string
    {
        return $this->historique3PlantationParcelle;
    }

    public function setHistorique3PlantationParcelle(?string $historique3PlantationParcelle): self
    {
        $this->historique3PlantationParcelle = $historique3PlantationParcelle;

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
