<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Livre>
     */
    #[ORM\OneToMany(targetEntity: Livre::class, mappedBy: 'emprunt')]
    private ?Collection $livre = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $lecteur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_emprunt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_retour = null;

    #[ORM\Column(length: 50)]
    private ?string $statut = null;

    public function __construct()
    {
        $this->livre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getLivre(): ?Collection
    {
        return $this->livre;
    }

    public function addLivre(?Livre $livre): static
    {
        if (!$this->livre->contains($livre)) {
            $this->livre->add($livre);
            $livre->setEmprunt($this);
        }

        return $this;
    }

    public function removeLivre(?Livre $livre): static
    {
        if ($this->livre->removeElement($livre)) {
            // set the owning side to null (unless already changed)
            if ($livre->getEmprunt() === $this) {
                $livre->setEmprunt(null);
            }
        }

        return $this;
    }

    public function getLecteur(): ?Utilisateur
    {
        return $this->lecteur;
    }

    public function setLecteur(?Utilisateur $lecteur): static
    {
        $this->lecteur = $lecteur;

        return $this;
    }

    public function getDateEmprunt(): ?\DateTime
    {
        return $this->date_emprunt;
    }

    public function setDateEmprunt(\DateTime $date_emprunt): static
    {
        $this->date_emprunt = $date_emprunt;

        return $this;
    }

    public function getDateRetour(): ?\DateTime
    {
        return $this->date_retour;
    }

    public function setDateRetour(\DateTime $date_retour): static
    {
        $this->date_retour = $date_retour;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
}
