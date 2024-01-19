<?php

namespace App\Entity;

use App\Repository\CheckListCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CheckListCategoryRepository::class)]
class CheckListCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'checkListCategory', targetEntity: CheckList::class, orphanRemoval: true)]
    private Collection $category;

    public function __construct()
    {
        $this->category = new ArrayCollection();
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
     * @return Collection<int, CheckList>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(CheckList $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
            $category->setCheckListCategory($this);
        }

        return $this;
    }

    public function removeCategory(CheckList $category): static
    {
        if ($this->category->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getCheckListCategory() === $this) {
                $category->setCheckListCategory(null);
            }
        }

        return $this;
    }
}
