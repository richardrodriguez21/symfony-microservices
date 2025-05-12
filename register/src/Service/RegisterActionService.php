<?php 
declare(strict_types=1);
namespace App\Service;

use App\Messenger\Message\UserRegisteredMessage;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Messenger\RoutingKey;

final class RegisterActionService
{
    public function __construct( private readonly MessageBusInterface $bus){

    }

    public function __invoke(string $name, string $email): void{
        $this->bus->dispatch(new UserRegisteredMessage($name, $email),
        [new AmqpStamp(RoutingKey::REGISTER_APPLICATION_QUEUE)]
    );
    }
}