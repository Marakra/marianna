<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\Point;
use App\Model\PointCollection;
use App\Model\PointParameters;
use DateTime;
use PDO;

final class DbPointRepository implements PointRepository
{
    private const RED_ICON = 'https://cdn.pixabay.com/photo/2013/07/13/01/09/map-155198__340.png';
    private const BLUE_ICON = 'https://cdn.pixabay.com/photo/2013/07/13/01/09/map-155196__340.png';
    private const GREEN_ICON = 'https://cdn.pixabay.com/photo/2013/07/13/01/09/map-155197__340.png';
    private const ICONS = [
        self::RED_ICON, self::BLUE_ICON, self::GREEN_ICON
    ];

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getAllPoints(): PointCollection
    {
        $points = [];
        $rows = $this->connection->query('SELECT * FROM points')->fetchAll();

        foreach ($rows as $row) {
            $points[] = $this->createPointModelFromRow($row);
        }

        return new PointCollection(...$points);
    }

    public function getPointInformationById(int $id): ?Point
    {
        $query = $this->connection->prepare('SELECT * FROM points WHERE id = :id');
        $query->bindValue('id', $id);
        $query->execute();

        $row = $query->fetch();

        if ($row === false) {
            return null;
        }

        return $this->createPointModelFromRow($row);
    }

    public function getPointInformationByLatAndLng(float $lat, float $lng): ?Point
    {
        $query = $this->connection->prepare('SELECT * FROM points WHERE lat = :lat AND lng = :lng');
        $query->bindValue('lat', $lat);
        $query->bindValue('lng', $lng);
        $query->execute();

        $row = $query->fetch();

        if ($row === false) {
            return null;
        }

        return $this->createPointModelFromRow($row);
    }

    public function store(Point $point): void
    {
        $query = $this->connection->prepare('
            INSERT INTO points (address, lat, lng, parameters, created_at, updated_at) 
            VALUES (:address, :lat, :lng, :parameters, :created_at, :updated_at)
        ');

        $query->execute([
            ':address' => $point->getAddress(),
            ':lat' => $point->getLat(),
            ':lng' => $point->getLng(),
            ':parameters' => json_encode($point->getParameters()->toArray()),
            ':created_at' => $point->getCreatedAt()->format('Y-m-d H:i:s'),
            ':updated_at' => null,
        ]);
    }

    public function save(Point $point): void
    {
        $query = $this->connection->prepare('
            UPDATE points SET 
                address = :address,
                lat = :lat,
                lng = :lng,
                parameters = :parameters, 
                created_at = :created_at, 
                updated_at = :updated_at 
            WHERE id = :id
        ');

        $query->execute([
            ':id' => $point->getId(),
            ':address' => $point->getAddress(),
            ':lat' => $point->getLat(),
            ':lng' => $point->getLng(),
            ':parameters' => json_encode($point->getParameters()->toArray()),
            ':created_at' => $point->getCreatedAt()->format('Y-m-d H:i:s'),
            ':updated_at' => $point->getUpdatedAt()->format('Y-m-d H:i:s'),
        ]);
    }

    private function createPointModelFromRow(array $row): Point
    {
        $parameters = json_decode($row['parameters'], true);

        return new Point(
            $row['id'],
            $row['address'],
            (float) $row['lat'],
            (float) $row['lng'],
            PointParameters::createFromArray($parameters),
            self::ICONS[array_rand(self::ICONS)],
            DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at']),
            $row['updated_at'] === null
                ? null
                : DateTime::createFromFormat('Y-m-d H:i:s', $row['updated_at']),
        );
    }
}
