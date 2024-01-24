<?php

namespace App\Entity;

use App\Repository\GuestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuestRepository::class)]
class Guest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isConfirmed = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isAccommodation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $transport = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isAdult = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isChildUnderThreeYears = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isChildBetweenThreeAndTwelve = null;

    #[ORM\Column(nullable: true)]
    private ?bool $specialDiet = null;

    #[ORM\ManyToOne(inversedBy: 'guests')]
    private ?User $user = null;

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

    public function isIsConfirmed(): ?bool
    {
        return $this->isConfirmed;
    }

    public function setIsConfirmed(?bool $isConfirmed): static
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    public function isIsAccommodation(): ?bool
    {
        return $this->isAccommodation;
    }

    public function setIsAccommodation(?bool $isAccommodation): static
    {
        $this->isAccommodation = $isAccommodation;

        return $this;
    }

    public function isTransport(): ?bool
    {
        return $this->transport;
    }

    public function setTransport(?bool $transport): static
    {
        $this->transport = $transport;

        return $this;
    }

    public function isIsAdult(): ?bool
    {
        return $this->isAdult;
    }

    public function setIsAdult(?bool $isAdult): static
    {
        $this->isAdult = $isAdult;

        return $this;
    }

    public function isIsChildUnderThreeYears(): ?bool
    {
        return $this->isChildUnderThreeYears;
    }

    public function setIsChildUnderThreeYears(?bool $isChildUnderThreeYears): static
    {
        $this->isChildUnderThreeYears = $isChildUnderThreeYears;

        return $this;
    }

    public function isIsChildBetweenThreeAndTwelve(): ?bool
    {
        return $this->isChildBetweenThreeAndTwelve;
    }

    public function setIsChildBetweenThreeAndTwelve(?bool $isChildBetweenThreeAndTwelve): static
    {
        $this->isChildBetweenThreeAndTwelve = $isChildBetweenThreeAndTwelve;

        return $this;
    }

    public function isSpecialDiet(): ?bool
    {
        return $this->specialDiet;
    }

    public function setSpecialDiet(?bool $specialDiet): static
    {
        $this->specialDiet = $specialDiet;

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
}
