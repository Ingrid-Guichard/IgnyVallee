<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SympathisantsRepository")
 */
class Sympathisants
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isIntPotager;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isIntVerger;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isIntRucher;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isIntAnimation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getIsIntPotager(): ?bool
    {
        return $this->isIntPotager;
    }

    public function setIsIntPotager(bool $isIntPotager): self
    {
        $this->isIntPotager = $isIntPotager;

        return $this;
    }

    public function getIsIntVerger(): ?bool
    {
        return $this->isIntVerger;
    }

    public function setIsIntVerger(bool $isIntVerger): self
    {
        $this->isIntVerger = $isIntVerger;

        return $this;
    }

    public function getIsIntRucher(): ?bool
    {
        return $this->isIntRucher;
    }

    public function setIsIntRucher(bool $isIntRucher): self
    {
        $this->isIntRucher = $isIntRucher;

        return $this;
    }

    public function getIsIntAnimation(): ?bool
    {
        return $this->isIntAnimation;
    }

    public function setIsIntAnimation(bool $isIntAnimation): self
    {
        $this->isIntAnimation = $isIntAnimation;

        return $this;
    }
}
