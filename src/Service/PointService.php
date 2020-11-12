<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Point;
use App\Model\PointCollection;
use App\Repository\PointRepository;
use App\Service\DTO\PointInformationDTO;

final class PointService
{
    private PointRepository $repository;

    public function __construct(PointRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllPoints(): PointCollection
    {
        return $this->repository->getAllPoints();
    }

    public function getPointInformation(int $id): ?Point
    {
        return $this->repository->getPointInformationById($id);
    }

    public function storePointInformation(PointInformationDTO $dto): void
    {
        $point = $this->repository->getPointInformationByLatAndLng($dto->getLat(), $dto->getLng());

        if ($point === null) {
            $point = Point::createNew(
                $dto->getAddress(),
                $dto->getLat(),
                $dto->getLng(),
                $dto->getParameters()
            );

            $this->repository->store($point);

            return;
        }

        $point->updateInformation($dto->getAddress(), $dto->getParameters());

        $this->repository->save($point);
    }
}
