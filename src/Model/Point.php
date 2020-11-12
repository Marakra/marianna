<?php
declare(strict_types=1);

namespace App\Model;

use DateTime;
use DateTimeInterface;

final class Point
{
    private ?int $id;
    private string $address;
    private float $lat;
    private float $lng;
    private PointParameters $parameters;
    private ?string $icon;
    private DateTimeInterface $createdAt;
    private ?DateTimeInterface $updatedAt;

    public function __construct(
        ?int $id,
        string $address,
        float $lat,
        float $lng,
        PointParameters $parameters,
        ?string $icon,
        DateTimeInterface $createdAt,
        ?DateTimeInterface $updatedAt
    ) {
        $this->id = $id;
        $this->address = $address;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->parameters = $parameters;
        $this->icon = $icon;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function createNew(string $address, float $lat, float $lng, PointParameters $parameters): self
    {
        return new self(
            null,
            $address,
            $lat,
            $lng,
            $parameters,
            null,
            new DateTime(),
            null
        );
    }

    public function updateInformation(string $address, PointParameters $parameters): void
    {
        $this->address = $address;
        $this->parameters = $parameters;
        $this->updatedAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function getLng(): float
    {
        return $this->lng;
    }

    public function getParameters(): PointParameters
    {
        return $this->parameters;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'parameters' => $this->parameters->toArray(),
            'icon' => $this->icon,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt === null ? null : $this->updatedAt->getTimestamp(),
        ];
    }
}
