<?php 
declare(strict_types=1);
namespace App\Messenger\Message;

final class UserRegisteredMessage
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
    ){}

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
