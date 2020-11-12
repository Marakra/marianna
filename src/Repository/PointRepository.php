<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\Point;
use App\Model\PointCollection;

interface PointRepository
{
    public function getAllPoints(): PointCollection;
    public function getPointInformationById(int $id): ?Point;
    public function getPointInformationByLatAndLng(float $lat, float $lng): ?Point;
    public function store(Point $point): void;
    public function save(Point $point): void;
}
