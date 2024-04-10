<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;




    #[ORM\ManyToMany(targetEntity: Intervenant::class, mappedBy: 'classesTaught')]
    private Collection $intervenants;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'classe')]
    private Collection $students;

    #[ORM\OneToMany(targetEntity: Matiere::class, mappedBy: 'classe')]
    private Collection $matieres;


    public function __construct()
    {
        $this->intervenants = new ArrayCollection();
        $this->students = new ArrayCollection();
        $this->matieres = new ArrayCollection();
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
     * @return Collection<int, Intervenant>
     */




    /**
     * @return Collection<int, User>
     */
    public function getstudents(): Collection
    {
        return $this->students;
    }

    public function addUser(User $user): static
    {
        if (!$this->students->contains($user)) {
            $this->students->add($user);
            $user->setClasse($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->students->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getClasse() === $this) {
                $user->setClasse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Intervenant>
     */
    public function getIntervenants(): Collection
    {
        return $this->intervenants;
    }

    public function addIntervenant(Intervenant $intervenant): static
    {
        if (!$this->intervenants->contains($intervenant)) {
            $this->intervenants->add($intervenant);
        }
        if (!$intervenant->getClassesTaught()->contains($this)) {
            $intervenant->addClassesTaught($this);
        }

        return $this;
    }

    public function removeIntervenant(Intervenant $intervenant): static
    {
        $this->intervenants->removeElement($intervenant);
        if ($intervenant->getClassesTaught()->contains($this)) {
            $intervenant->removeClassesTaught($this);
        }

        return $this;
    }

    public function __toString() : string{
        return $this->name;
    }



    public function addStudent(User $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setClasse($this);
        }

        return $this;
    }

    public function removeStudent(User $student): static
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getClasse() === $this) {
                $student->setClasse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matiere>
     */
    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addMatiere(Matiere $matiere): static
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres->add($matiere);
            $matiere->setClasse($this);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): static
    {
        if ($this->matieres->removeElement($matiere)) {
            // set the owning side to null (unless already changed)
            if ($matiere->getClasse() === $this) {
                $matiere->setClasse(null);
            }
        }

        return $this;
    }




}
