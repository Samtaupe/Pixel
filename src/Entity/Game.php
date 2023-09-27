<?php 

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

// Indique à Doctrine que cette classe correspond à une table
#[ORM\Entity]
class Game
{
    #[ORM\Id] // Clé primaire
    #[ORM\GeneratedValue] // Auto increment
    #[ORM\Column]
    private int|null $id = null;

    #[ORM\Column]
    private string $name;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private string|null $description;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private \DateTime|null $releaseDate = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Support::class)]
    private Collection $support;

    public function __construct()
    {
        $this->support = new ArrayCollection();
    }

    public function getId(): int|null
    {
        return $this->id;
    }
 
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): null|string
    {
        return $this->description;
    }

    public function setDescription(null|string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getReleaseDate(): \DateTime|null
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTime|null $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, support>
     */
    public function getSupport(): Collection
    {
        return $this->support;
    }

    public function addSupport(Support $support): static
    {
        if (!$this->support->contains($support)) {
            $this->support->add($support);
        }

        return $this;
    }

    public function removeSupport(Support $support): static
    {
        $this->support->removeElement($support);

        return $this;
    }
}