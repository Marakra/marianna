<?php
declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../../.env');

$queue = $_ENV['QUEUE_NAME'];
$connection = new AMQPStreamConnection(
    $_ENV['QUEUE_HOST'],
    $_ENV['QUEUE_PORT'],
    $_ENV['QUEUE_USER'],
    $_ENV['QUEUE_PASSWORD']
);
$channel = $connection->channel();
$channel->queue_declare($queue, false, true, false, false, false);

$messageBody = '{
    "Location": "Gdansk Wrzeszcz, Gdansk, Poland", 
    "Latitude": "54.380277777778", 
    "Longitude": "18.620277777778", 
    "Time": "2020-11-10 14:00:00", 
    "PM 2.5": "11",
    "PM 10": "26", 
    "O3": "16.8", 
    "NO2": "6.1", 
    "SO2": "0.8", 
    "CO": "3.2"
}';

$message = new AMQPMessage($messageBody);
$channel->basic_publish($message, '', $queue);

$channel->close();
$connection->close();