<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminsRepository")
 */
class Admins
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
    private $heuresGestionAdmin;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Events", mappedBy="admins")
     */
    private $events;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Adherents", inversedBy="admin")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adherent;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeuresGestionAdmin(): ?int
    {
        return $this->heuresGestionAdmin;
    }

    public function setHeuresGestionAdmin(int $heuresGestionAdmin): self
    {
        $this->heuresGestionAdmin = $heuresGestionAdmin;

        return $this;
    }

    public function addHeuresGestionAdmin(int $heuresGestionAdmin): self
    {
        $this->heuresGestionAdmin += $heuresGestionAdmin;

        return $this;
    }

    /**
     * @return Collection|Events[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Events $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addAdmin($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            $event->removeAdmin($this);
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
}
