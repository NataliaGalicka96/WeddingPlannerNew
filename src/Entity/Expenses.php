<?php

namespace App\Entity;

use App\Repository\ExpensesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpensesRepository::class)]
class Expenses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $expense = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $price = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $alreadyPaid = null;

    #[ORM\ManyToOne(inversedBy: 'expenses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'expenses')]
    private ?BudgetCategory $budgetCategory = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpense(): ?string
    {
        return $this->expense;
    }

    public function setExpense(string $expense): static
    {
        $this->expense = $expense;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getAlreadyPaid(): ?string
    {
        return $this->alreadyPaid;
    }

    public function setAlreadyPaid(?string $alreadyPaid): static
    {
        $this->alreadyPaid = $alreadyPaid;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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
