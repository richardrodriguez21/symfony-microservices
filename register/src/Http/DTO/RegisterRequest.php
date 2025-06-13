<?php
declare(strict_types=1);

namespace App\Http\DTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

final class RegisterRequest implements RequestDTO
{
    #[Assert\NotBlank]
    #[Assert\Email]
    private  ?string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private  ?string $name;

    public function __construct(Request $request)
    {
        $data = \json_decode($request->getContent(), true);

        $this->email = $data['email'] ?? '';
        $this->name = $data['name'] ?? '';
    }

    public function getEmail(): string
    {
        return $this->email;
    }       

    public function getName(): string
    {
        return $this->name;
    }
}