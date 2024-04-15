<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Validator\MailParisUn;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Unique;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Unique (null,"Nom d'utilisateur déjà utilisé")]
    private ?string $username = null;

    /**
     * @var list<string> The makeadminview roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[MailParisUn]
    #[Unique(null,"Mail déjà utilisé")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'author')]
    private Collection $reviews;

    #[ORM\ManyToOne(inversedBy: 'students')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Classe $classe = null;

    #[ORM\Column]
    private ?bool $isVerified = false;

    #[ORM\Column]
    private ?bool $isBanned = false;

    #[ORM\ManyToMany(targetEntity: Review::class, inversedBy: 'usersThatLiked')]
    #[ORM\JoinTable(name: 'user_liked_reviews')]
    private Collection $likedReviews;

    #[ORM\ManyToMany(targetEntity: Review::class, inversedBy: 'usersThatDisliked')]
    #[ORM\JoinTable(name: 'user_disliked_reviews')]
    private Collection $dislikedReviews;



    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->likedReviews = new ArrayCollection();
        $this->dislikedReviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this makeadminview.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every makeadminview at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }
    public function addRole(string $role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the makeadminview, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

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
            $review->setAuthor($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getAuthor() === $this) {
                $review->setAuthor(null);
            }
        }

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
    public function getName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function isIsBanned(): ?bool
    {
        return $this->isBanned;
    }

    public function setIsBanned(bool $isBanned): static
    {
        $this->isBanned = $isBanned;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getLikedReviews(): Collection
    {
        return $this->likedReviews;
    }

    public function addLikedReview(Review $likedReview): static
    {
        if (!$this->likedReviews->contains($likedReview)) {
            $this->likedReviews->add($likedReview);
            $likedReview->addUserThatLiked($this);
        }

        return $this;
    }

    public function removeLikedReview(Review $likedReview): static
    {
        $this->likedReviews->removeElement($likedReview);
        $likedReview->removeUserThatLiked($this);
        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getDislikedReviews(): Collection
    {
        return $this->dislikedReviews;
    }

    public function addDislikedReview(Review $dislikedReview): static
    {
        if (!$this->dislikedReviews->contains($dislikedReview)) {
            $this->dislikedReviews->add($dislikedReview);
            $dislikedReview->addUserThatDisliked($this);
        }

        return $this;
    }

    public function removeDislikedReview(Review $dislikedReview): static
    {
        $this->dislikedReviews->removeElement($dislikedReview);
        $dislikedReview->removeUserThatDisliked($this);
        return $this;
    }


}
