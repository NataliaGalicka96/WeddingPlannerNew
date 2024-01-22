<?php

namespace App\Entity;

use App\Repository\DefaultExpensesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DefaultExpensesRepository::class)]
class DefaultExpenses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'expense')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BudgetCategory $budgetCategory = null;

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

    public function getBudgetCategory(): ?BudgetCategory
    {
        return $this->budgetCategory;
    }

    public function setBudgetCategory(?BudgetCategory $budgetCategory): static
    {
        $this->budgetCategory = $budgetCategory;

        return $this;
    }
}
