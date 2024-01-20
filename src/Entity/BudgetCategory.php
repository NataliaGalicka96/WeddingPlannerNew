<?php

namespace App\Entity;

use App\Repository\BudgetCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BudgetCategoryRepository::class)]
class BudgetCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;


    #[ORM\OneToMany(mappedBy: 'budgetCategory', targetEntity: DefaultExpenses::class)]
    private Collection $expense;

    #[ORM\OneToMany(mappedBy: 'budgetCategory', targetEntity: Expenses::class)]
    private Collection $expenses;

    public function __construct()
    {
        $this->expense = new ArrayCollection();
        $this->expenses = new ArrayCollection();
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
     * @return Collection<int, DefaultExpenses>
     */
    public function getExpense(): Collection
    {
        return $this->expense;
    }

    public function addExpense(DefaultExpenses $expense): static
    {
        if (!$this->expense->contains($expense)) {
            $this->expense->add($expense);
            $expense->setBudgetCategory($this);
        }

        return $this;
    }

    public function removeExpense(DefaultExpenses $expense): static
    {
        if ($this->expense->removeElement($expense)) {
            // set the owning side to null (unless already changed)
            if ($expense->getBudgetCategory() === $this) {
                $expense->setBudgetCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Expenses>
     */
    public function getExpenses(): Collection
    {
        return $this->expenses;
    }
}
