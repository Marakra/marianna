<?php
declare(strict_types=1);

namespace App\Service\DTO;

use App\Model\PointParameters;

final class PointInformationDTO
{
    private float $lat;
    private float $lng;
    private string $address;
    private PointParameters $parameters;

    public function __construct(float $lat, float $lng, string $address, PointParameters $parameters)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->address = $address;
        $this->parameters = $parameters;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function getLng(): float
    {
        return $this->lng;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getParameters(): PointParameters
    {
        return $this->parameters;
    }
}
