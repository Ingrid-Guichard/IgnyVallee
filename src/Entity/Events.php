<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventsRepository")
 */
class Events
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
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $heuresGestionEvent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaires", inversedBy="events")
     */
    private $partenaire;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Participants", mappedBy="events")
     */
    private $participants;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Admins", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $admins;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->admins = new ArrayCollection();
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

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

    public function getHeuresGestionEvent(): ?int
    {
        return $this->heuresGestionEvent;
    }

    public function setHeuresGestionEvent(int $heuresGestionEvent): self
    {
        $this->heuresGestionEvent = $heuresGestionEvent;

        return $this;
    }

    public function getPartenaire(): ?Partenaires
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaires $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }

    /**
     * @return Collection|Participants[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participants $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->addEvent($this);
        }

        return $this;
    }

    public function removeParticipant(Participants $participant): self
    {
        if ($this->participants->contains($participant)) {
            $this->participants->removeElement($participant);
            $participant->removeEvent($this);
        }

        return $this;
    }

    /**
     * @return Collection|Admins[]
     */
    public function getAdmins(): Collection
    {
        return $this->admins;
    }

    public function addAdmin(Admins $admin): self
    {
        if (!$this->admins->contains($admin)) {
            $this->admins[] = $admin;
        }

        return $this;
    }

    public function removeAdmin(Admins $admin): self
    {
        if ($this->admins->contains($admin)) {
            $this->admins->removeElement($admin);
        }

        return $this;
    }
}
