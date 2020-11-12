<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdherentsRepository")
 * @UniqueEntity(fields={"email"}, message="Un compte est déjà associé à cette adresse email")
 */
class Adherents implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email(
     *     message = "L'email entré n'est pas de forme valide"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

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
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(pattern="[(0|\\+33|0033)[1-9][0-9]{8}]", message="Le numéro de téléphone spécifié n'est pas valide")
     */
    private $telephone;

    /**
     * @ORM\Column(type="date")
     */
    private $debutAdhesion;

    /**
     * @ORM\Column(type="date")
     */
    private $finAdhesion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActPotager;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActVerger;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActRucher;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActAnimation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActPromotion;

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

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAdmin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPayed;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typePaiement;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isArchive;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Admins", mappedBy="adherent", orphanRemoval=true)
     */
    private $admin;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Participants", mappedBy="adherent", cascade={"persist", "remove"})
     */
    private $participant;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Emprunts", mappedBy="adherent", orphanRemoval=true)
     */
    private $emprunts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cotisations", mappedBy="adherent", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=false)
     */
    private $cotisations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Ateliers", inversedBy="adherents")
     */
    private $ateliers;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Referents", mappedBy="adherent", orphanRemoval=true)
     */
    private $referent;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Activites", inversedBy="adherents")
     */
    private $activites;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Arbres", mappedBy="adherent")
     */
    private $arbres;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valide;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isReferentP;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isReferentR;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isReferentV;

    /**
     * @ORM\OneToMany(targetEntity=FichesDeVisite::class, mappedBy="adherent")
     */
    private $fichesDeVisites;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeAdhesion;

    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
        $this->cotisations = new ArrayCollection();
        $this->ateliers = new ArrayCollection();
        $this->activites = new ArrayCollection();
        $this->arbres = new ArrayCollection();
        $this->fichesDeVisites = new ArrayCollection();
    }

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
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getDebutAdhesion(): ?\DateTimeInterface
    {
        return $this->debutAdhesion;
    }

    public function setDebutAdhesion(\DateTimeInterface $debutAdhesion): self
    {
        $this->debutAdhesion = $debutAdhesion;

        return $this;
    }

    public function getFinAdhesion(): ?\DateTimeInterface
    {
        return $this->finAdhesion;
    }

    public function setFinAdhesion(\DateTimeInterface $finAdhesion): self
    {
        $this->finAdhesion = $finAdhesion;

        return $this;
    }

    public function getIsActPotager(): ?bool
    {
        return $this->isActPotager;
    }

    public function setIsActPotager(bool $isActPotager): self
    {
        $this->isActPotager = $isActPotager;

        return $this;
    }

    public function getIsActVerger(): ?bool
    {
        return $this->isActVerger;
    }

    public function setIsActVerger(bool $isActVerger): self
    {
        $this->isActVerger = $isActVerger;

        return $this;
    }

    public function getIsActRucher(): ?bool
    {
        return $this->isActRucher;
    }

    public function setIsActRucher(bool $isActRucher): self
    {
        $this->isActRucher = $isActRucher;

        return $this;
    }

    public function getIsActAnimation(): ?bool
    {
        return $this->isActAnimation;
    }

    public function setIsActAnimation(bool $isActAnimation): self
    {
        $this->isActAnimation = $isActAnimation;

        return $this;
    }

    public function getIsActPromotion(): ?bool
    {
        return $this->isActPromotion;
    }

    public function setIsActPromotion(bool $isActPromotion): self
    {
        $this->isActPromotion = $isActPromotion;

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

    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getIsArchive(): ?bool
    {
        return $this->isArchive;
    }

    public function setIsArchive(bool $isArchive): self
    {
        $this->isArchive = $isArchive;

        return $this;
    }

    public function getTypePaiement(): ?string
    {
        return $this->typePaiement;
    }

    public function setTypePaiement(?string $typePaiement): self
    {
        $this->typePaiement = $typePaiement;

        return $this;
    }

    public function getIsPayed(): ?bool
    {
        return $this->isPayed;
    }

    public function setIsPayed(bool $isPayed): self
    {
        $this->isPayed = $isPayed;

        return $this;
    }

    public function getAdmin(): ?Admins
    {
        return $this->admin;
    }

    public function setAdmin(Admins $admin): self
    {
        $this->admin = $admin;

        // set the owning side of the relation if necessary
        if ($admin->getAdherent() !== $this) {
            $admin->setAdherent($this);
        }

        return $this;
    }

    public function getParticipant(): ?Participants
    {
        return $this->participant;
    }

    public function setParticipant(?Participants $participant): self
    {
        $this->participant = $participant;

        // set (or unset) the owning side of the relation if necessary
        $newAdherent = null === $participant ? null : $this;
        if ($participant->getAdherent() !== $newAdherent) {
            $participant->setAdherent($newAdherent);
        }

        return $this;
    }

    /**
     * @return Collection|Emprunts[]
     */
    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }

    public function addEmprunt(Emprunts $emprunt): self
    {
        if (!$this->emprunts->contains($emprunt)) {
            $this->emprunts[] = $emprunt;
            $emprunt->setAdherent($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunts $emprunt): self
    {
        if ($this->emprunts->contains($emprunt)) {
            $this->emprunts->removeElement($emprunt);
            // set the owning side to null (unless already changed)
            if ($emprunt->getAdherent() === $this) {
                $emprunt->setAdherent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cotisations[]
     */
    public function getCotisations(): Collection
    {
        return $this->cotisations;
    }

    public function addCotisation(Cotisations $cotisation): self
    {
        if (!$this->cotisations->contains($cotisation)) {
            $this->cotisations[] = $cotisation;
            $cotisation->setAdherent($this);
        }

        return $this;
    }

    public function removeCotisation(Cotisations $cotisation): self
    {
        if ($this->cotisations->contains($cotisation)) {
            $this->cotisations->removeElement($cotisation);
            // set the owning side to null (unless already changed)
            if ($cotisation->getAdherent() === $this) {
                $cotisation->setAdherent(null);
            }
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
        }

        return $this;
    }

    public function removeAtelier(Ateliers $atelier): self
    {
        if ($this->ateliers->contains($atelier)) {
            $this->ateliers->removeElement($atelier);
        }

        return $this;
    }

    public function getReferent(): ?Referents
    {
        return $this->referent;
    }

    public function setReferent(Referents $referent): self
    {
        $this->referent = $referent;

        // set the owning side of the relation if necessary
        if ($referent->getAdherent() !== $this) {
            $referent->setAdherent($this);
        }

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
            $arbre->setAdherent($this);
        }

        return $this;
    }

    public function removeArbre(Arbres $arbre): self
    {
        if ($this->arbres->contains($arbre)) {
            $this->arbres->removeElement($arbre);
            // set the owning side to null (unless already changed)
            if ($arbre->getAdherent() === $this) {
                $arbre->setAdherent(null);
            }
        }

        return $this;
    }

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getIsReferentP(): ?bool
    {
        return $this->isReferentP;
    }

    public function setIsReferentP(bool $isReferentP): self
    {
        $this->isReferentP = $isReferentP;

        return $this;
    }

    public function getIsReferentR(): ?bool
    {
        return $this->isReferentR;
    }

    public function setIsReferentR(bool $isReferentR): self
    {
        $this->isReferentR = $isReferentR;

        return $this;
    }

    public function getIsReferentV(): ?bool
    {
        return $this->isReferentV;
    }

    public function setIsReferentV(bool $isReferentV): self
    {
        $this->isReferentV = $isReferentV;

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
            $fichesDeVisite->setAdherent($this);
        }

        return $this;
    }

    public function removeFichesDeVisite(FichesDeVisite $fichesDeVisite): self
    {
        if ($this->fichesDeVisites->contains($fichesDeVisite)) {
            $this->fichesDeVisites->removeElement($fichesDeVisite);
            // set the owning side to null (unless already changed)
            if ($fichesDeVisite->getAdherent() === $this) {
                $fichesDeVisite->setAdherent(null);
            }
        }

        return $this;
    }

    public function getTypeAdhesion(): ?string
    {
        return $this->typeAdhesion;
    }

    public function setTypeAdhesion(?string $typeAdhesion): self
    {
        $this->typeAdhesion = $typeAdhesion;

        return $this;
    }
}
