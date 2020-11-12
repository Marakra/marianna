<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\Point;
use App\Model\PointCollection;
use App\Model\PointParameters;
use DateTime;

final class MockPointRepository implements PointRepository
{
    private const RED_ICON = 'https://cdn.pixabay.com/photo/2013/07/13/01/09/map-155198__340.png';
    private const BLUE_ICON = 'https://cdn.pixabay.com/photo/2013/07/13/01/09/map-155196__340.png';
    private const GREEN_ICON = 'https://cdn.pixabay.com/photo/2013/07/13/01/09/map-155197__340.png';
    private const ICONS = [
        self::RED_ICON, self::BLUE_ICON, self::GREEN_ICON
    ];

    private const MOCK_DATA = [
        [
            'id' => 1,
            'address' => 'MOCK ul. Ogrodowa 10, Gdańsk',
            'lat' => 54.3697946,
            'lng' => 18.5761028,
            'parameters' => [
                'temperature' => 22.5,
                'pm25' => 56,
                'pm10' => 12,
                'o3' => 19,
                'no2' => 11,
                'so2' => 12,
                'co' => 45
            ],
            'created_at' => '2020-10-20 08:00:00',
            'updated_at' => '2020-10-20 08:00:00',
        ],
        [
            'id' => 2,
            'address' => 'MOCK ul. Jana Pawła II 3C, Gdańsk',
            'lat' => 54.3916379,
            'lng' => 18.6020306,
            'parameters' => [
                'temperature' => 22.5,
                'pm25' => 56,
                'pm10' => 12,
                'o3' => 19,
                'no2' => 11,
                'so2' => 12,
                'co' => 45
            ],
            'created_at' => '2020-10-20 08:00:00',
            'updated_at' => '2020-10-20 08:00:00',
        ],
        [
            'id' => 4,
            'address' => 'MOCK ul. Popiełuszki 10, Gdańsk',
            'lat' => 54.3634553,
            'lng' => 18.648608,
            'parameters' => [
                'temperature' => 22.5,
                'pm25' => 56,
                'pm10' => 12,
                'o3' => 19,
                'no2' => 11,
                'so2' => 12,
                'co' => 45
            ],
            'created_at' => '2020-10-20 08:00:00',
            'updated_at' => '2020-10-20 08:00:00',
        ],
        [
            'id' => 3,
            'address' => 'MOCK al. Wyzwolenia 221, Gdańsk',
            'lat' => 54.40123,
            'lng' => 18.6539325,
            'parameters' => [
                'temperature' => 22.5,
                'pm25' => 56,
                'pm10' => 12,
                'o3' => 19,
                'no2' => 11,
                'so2' => 12,
                'co' => 45
            ],
            'created_at' => '2020-10-20 08:00:00',
            'updated_at' => '2020-10-20 08:00:00',
        ],
        [
            'id' => 1,
            'address' => 'MOCK ul. Opacka 34, Gdańsk',
            'lat' => 54.4131861,
            'lng' => 18.5630103,
            'parameters' => [
                'temperature' => 22.5,
                'pm25' => 56,
                'pm10' => 12,
                'o3' => 19,
                'no2' => 11,
                'so2' => 12,
                'co' => 45
            ],
            'created_at' => '2020-10-20 08:00:00',
            'updated_at' => '2020-10-20 08:00:00',
        ],
    ];

    public function getAllPoints(): PointCollection
    {
        $points = [];

        foreach (self::MOCK_DATA as $mockItem) {
            $points[] = $this->createPointModelFromArray($mockItem);
        }

        return new PointCollection(...$points);
    }

    public function getPointInformationById(int $id): ?Point
    {
        foreach (self::MOCK_DATA as $item) {
            if ($item['id'] === $id) {
                return $this->createPointModelFromArray($item);
            }
        }

        return null;
    }

    public function getPointInformationByLatAndLng(float $lat, float $lng): ?Point
    {
        foreach (self::MOCK_DATA as $item) {
            if ($item['lat'] === $lat && $item['lng'] === $lng) {
                return $this->createPointModelFromArray($item);
            }
        }

        return null;
    }

    public function store(Point $point): void
    {
        // Can't be implemented in mock class.
    }

    public function save(Point $point): void
    {
        // Can't be implemented in mock class.
    }

    private function createPointModelFromArray(array $point): Point
    {
        return new Point(
            $point['id'],
            $point['address'],
            $point['lat'],
            $point['lng'],
            PointParameters::createFromArray($point['parameters']),
            self::ICONS[array_rand(self::ICONS)],
            DateTime::createFromFormat('Y-m-d H:i:s', $point['created_at']),
            $point['updated_at'] === null
                ? null
                : DateTime::createFromFormat('Y-m-d H:i:s', $point['updated_at']),
        );
    }
}
