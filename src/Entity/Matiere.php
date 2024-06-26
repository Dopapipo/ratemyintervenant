<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
class Matiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity:Intervenant::class, mappedBy: 'matieresEnseignees')]
    private Collection $intervenants;

    #[ORM\ManyToOne(inversedBy: 'matieres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Classe $classe = null;

    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'matiere')]
    private Collection $reviews;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->intervenants = new ArrayCollection();
    }
    public function __toString(): string
    {
        // Retourne le nom de la matière
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIntervenants(): Collection
    {
        return $this->intervenants;
    }

    public function addIntervenant(?Intervenant $intervenant): static
    {
        if (!$this->intervenants->contains($intervenant)) {
            $this->intervenants->add($intervenant);
        }
        if (!$intervenant->getMatieresEnseignees()->contains($this)) {
            $intervenant->addMatieresEnseignee($this);
        }

        return $this;
    }
    public function removeIntervenant(?Intervenant $intervenant): static
    {
        $this->intervenants->removeElement($intervenant);
        $intervenant->getMatieresEnseignees()->removeElement($this);
        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setMatiere($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getMatiere() === $this) {
                $review->setMatiere(null);
            }
        }
        return $this;
    }
}
