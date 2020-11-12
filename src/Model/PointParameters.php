<?php
declare(strict_types=1);

namespace App\Model;

final class PointParameters
{
    private ?string $temperature;
    private ?string $pm25;
    private ?string $pm10;
    private ?string $o3;
    private ?string $no2;
    private ?string $so2;
    private ?string $co;

    public function __construct(
        ?string $temperature,
        ?string $pm25,
        ?string $pm10,
        ?string $o3,
        ?string $no2,
        ?string $so2,
        ?string $co
    ) {
        $this->temperature = $temperature;
        $this->pm25 = $pm25;
        $this->pm10 = $pm10;
        $this->o3 = $o3;
        $this->no2 = $no2;
        $this->so2 = $so2;
        $this->co = $co;
    }

    public static function createFromArray(array $parameters): self
    {
        return new self(
            (string) $parameters['temperature'],
            (string) $parameters['pm25'],
            (string) $parameters['pm10'],
            (string) $parameters['o3'],
            (string) $parameters['no2'],
            (string) $parameters['so2'],
            (string) $parameters['co']
        );
    }

    public function toArray(): array
    {
        return [
            'temperature' => $this->temperature,
            'pm25' => $this->pm25,
            'pm10' => $this->pm10,
            'o3' => $this->o3,
            'no2' => $this->no2,
            'so2' => $this->so2,
            'co' => $this->co,
        ];
    }
}
