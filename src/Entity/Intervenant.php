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

    #[ORM\ManyToMany(targetEntity: Classe::class, inversedBy: 'intervenants')]
    #[ORM\JoinTable(name: 'intervenant_classe')]
    private Collection $classesTaught;

    #[ORM\ManyToMany(targetEntity: Matiere::class, inversedBy: 'intervenants')]
    #[ORM\JoinTable(name: 'intervenant_matiere')]
    private Collection $matieresEnseignees;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profilePictureFileName = "b006426e3e57f1f2c0b31e401fe8d21711839bc9.png";

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->classesTaught = new ArrayCollection();
        $this->matieresEnseignees = new ArrayCollection();
    }

    public function __toString(): string
    {
        // Retourne le nom de l'intervenant
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
    public function getImagePath() {
        $imagepath = "uploads/profilePictures/".$this->profilePictureFileName;
        return $imagepath;
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
            if (!$classesTaught->getIntervenants()->contains($this)) {
                $classesTaught->addIntervenant($this);
            }
        }

        return $this;
    }

    public function removeClassesTaught(Classe $classesTaught): static
    {
        if ($this->classesTaught->removeElement($classesTaught)) {

            if ($classesTaught->getIntervenants()->contains($this)) {
                $classesTaught->removeIntervenant($this);
            }

    }        return $this;

    }

    /**
     * @return Collection<int, Matiere>
     */
    public function getMatieresEnseignees(): Collection
    {
        return $this->matieresEnseignees;
    }

    public function addMatieresEnseignee(Matiere $matieresEnseignee): static
    {
        if (!$this->matieresEnseignees->contains($matieresEnseignee)) {
            $this->matieresEnseignees->add($matieresEnseignee);
            $matieresEnseignee->addIntervenant($this);
        }

        return $this;
    }

    public function removeMatieresEnseignee(Matiere $matieresEnseignee): static
    {
        if ($this->matieresEnseignees->removeElement($matieresEnseignee)) {
            $matieresEnseignee->removeIntervenant($this);
        }

        return $this;
    }

    public function getProfilePictureFileName(): ?string
    {
        return $this->profilePictureFileName;
    }

    public function setProfilePictureFileName(?string $profilePictureFileName): static
    {
        $this->profilePictureFileName = $profilePictureFileName;

        return $this;
    }
    public function getAverage() {
        $sum = 0;
        $count = 0;
        foreach ($this->reviews as $review) {
            $sum += $review->getGrade();
            $count++;
        }
        if ($count == 0) {
            return 0;
        }
        return  round($sum / $count, 2);
    }
}
