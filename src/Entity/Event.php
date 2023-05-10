<?php

namespace App\Entity;

use App\Repository\EventRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    private ?string $name;

    #[ORM\Column]
    private ?bool $isAuthorized;

    #[ORM\Column(length: 255)]
    private ?string $ipAddress;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isAuthorized(): ?bool
    {
        return $this->isAuthorized;
    }

    public function setIsAuthorized(bool $isAuthorised): self
    {
        $this->isAuthorized = $isAuthorised;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'isAuthorized' => $this->isAuthorized,
            'ipAddress' => $this->ipAddress,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }
}
