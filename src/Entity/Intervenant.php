<?php

namespace App\Entity;

use App\Repository\IntervenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IntervenantRepository::class)]
class Intervenant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;



    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'intervenant')]
    private Collection $reviews;

    #[ORM\ManyToMany(targetEntity: Classe::class, mappedBy: 'intervenants')]
    private Collection $classesTaught;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->classesTaught = new ArrayCollection();
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

    /**
     * @return Collection<int, Classe>
     */




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
            $review->setIntervenant($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getIntervenant() === $this) {
                $review->setIntervenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClassesTaught(): Collection
    {
        return $this->classesTaught;
    }

    public function addClassesTaught(Classe $classesTaught): static
    {
        if (!$this->classesTaught->contains($classesTaught)) {
            $this->classesTaught->add($classesTaught);
            $classesTaught->addIntervenant($this);
        }

        return $this;
    }

    public function removeClassesTaught(Classe $classesTaught): static
    {
        if ($this->classesTaught->removeElement($classesTaught)) {
            $classesTaught->removeIntervenant($this);
        }

        return $this;
    }
}
