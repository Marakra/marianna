<?php
declare(strict_types=1);

namespace App\Model;

final class PointCollection
{
    private array $points;

    public function __construct(Point ...$points)
    {
        $this->points = $points;
    }

    public function getPoints(): array
    {
        return $this->points;
    }

    public function toArray(): array
    {
        return array_map(static fn(Point $point) => $point->toArray(), $this->points);
    }
}
