<?php
declare(strict_types=1);

use App\Model\PointParameters;
use App\Service\DTO\PointInformationDTO;
use App\Service\PointService;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
/** @var PointService $pointService */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/app.php';

$queue = $_ENV['QUEUE_NAME'];
$connection = new AMQPStreamConnection(
    $_ENV['QUEUE_HOST'],
    $_ENV['QUEUE_PORT'],
    $_ENV['QUEUE_USER'],
    $_ENV['QUEUE_PASSWORD']
);
$channel = $connection->channel();

$channel->queue_declare($queue, false, true, false, false);

$messageProcessor = static function (AMQPMessage $message) use ($pointService): void {
    $pointInformation = json_decode($message->body, true);
    $pointInformationDTO = new PointInformationDTO(
        (float)$pointInformation['Latitude'],
        (float)$pointInformation['Longitude'],
        $pointInformation['Location'],
        new PointParameters(
            null,
            (string) $pointInformation['PM 2.5'],
            (string) $pointInformation['PM 10'],
            (string) $pointInformation['O3'],
            (string) $pointInformation['NO2'],
            (string) $pointInformation['SO2'],
            (string) $pointInformation['CO'],
        )
    );

    $pointService->storePointInformation($pointInformationDTO);

    $message->ack();
    echo "Message processed\n";
};

$channel->basic_consume($queue, '', false, false, false, false, $messageProcessor);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();