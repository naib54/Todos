<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $Name = null;

    #[ORM\OneToMany(mappedBy: 'Category', targetEntity: Tasks::class)]
    private Collection $Ctagories;

    public function __construct()
    {
        $this->Ctagories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection<int, Tasks>
     */
    public function getCtagories(): Collection
    {
        return $this->Ctagories;
    }

    public function addCtagory(Tasks $ctagory): static
    {
        if (!$this->Ctagories->contains($ctagory)) {
            $this->Ctagories->add($ctagory);
            $ctagory->setCategory($this);
        }

        return $this;
    }

    public function removeCtagory(Tasks $ctagory): static
    {
        if ($this->Ctagories->removeElement($ctagory)) {
            // set the owning side to null (unless already changed)
            if ($ctagory->getCategory() === $this) {
                $ctagory->setCategory(null);
            }
        }

        return $this;
    }
}
