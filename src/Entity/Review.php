<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Intervenant $intervenant = null;

    #[ORM\Column(length: 2000, nullable: true)]
    private ?string $content = null;

    #[ORM\Column]
    private ?int $grade = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    private ?User $author = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Matiere $matiere = null;

    #[ORM\Column(type: 'integer')]
    private int $likes = 0;

    #[ORM\Column(type: 'integer')]
    private int $dislikes = 0;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'likedReviews')]
    private Collection $usersThatLiked;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'dislikedReviews')]
    private Collection $usersThatDisliked;

    #[ORM\Column(nullable: true)]

    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->usersThatLiked = new ArrayCollection();
        $this->usersThatDisliked = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntervenant(): ?Intervenant
    {
        return $this->intervenant;
    }

    public function setIntervenant(?Intervenant $intervenant): static
    {
        $this->intervenant = $intervenant;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getGrade(): ?int
    {
        return $this->grade;
    }

    public function setGrade(int $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): static
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
    }

    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    public function setDislikes(int $dislikes): void
    {
        $this->dislikes = $dislikes;
    }

    public function like(): void
    {
        $this->likes++;
    }

    public function dislike(): void
    {
        $this->dislikes++;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsersThatLiked(): Collection
    {
        return $this->usersThatLiked;
    }

    public function addUserThatLiked(User $usersThatLiked): static
    {
        if (!$this->usersThatLiked->contains($usersThatLiked)) {
            $this->usersThatLiked->add($usersThatLiked);
            $usersThatLiked->addLikedReview($this);
        }

        return $this;
    }

    public function removeUserThatLiked(User $usersThatLiked): static
    {
        if ($this->usersThatLiked->removeElement($usersThatLiked)) {
            $usersThatLiked->removeLikedReview($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsersThatDisliked(): Collection
    {
        return $this->usersThatDisliked;
    }

    public function addUserThatDisliked(User $usersThatDisliked): static
    {
        if (!$this->usersThatDisliked->contains($usersThatDisliked)) {
            $this->usersThatDisliked->add($usersThatDisliked);
            $usersThatDisliked->addDislikedReview($this);
        }

        return $this;
    }

    public function removeUserThatDisliked(User $usersThatDisliked): static
    {
        if ($this->usersThatDisliked->removeElement($usersThatDisliked)) {
            $usersThatDisliked->removeDislikedReview($this);
        }

        return $this;
    }

    public function isLikedByUser(User $user): bool
    {
        return $this->usersThatLiked->contains($user);
    }

    public function isDislikedByUser(User $user): bool
    {
        return $this->usersThatDisliked->contains($user);
    }


    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
