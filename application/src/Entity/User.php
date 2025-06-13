<?php 
declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity()]
#[ORM\Table(name: 'users')]
#[ORM\UniqueConstraint(name: 'email_unique', columns: ['email'])]
class User
{

    #[ORM\Id]
    #[ORM\Column(type: 'string', columnDefinition: 'CHAR(36) NOT NULL')]
    private string $id;

    #[ORM\Column(length: 20)]
    private string $name;

    #[ORM\Column(length: 100)]
    private string $email;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $password; 

    #[ORM\Column(type: 'datetime', columnDefinition: 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP')]
    private \DateTime $createdOn;
  

    public function __construct(string $name, string $email){
        $this->id = Uuid::v4()->toRfc4122();
        $this->name = $name;
        $this->email = $email;
        $this->password = null;
        $this->createdOn = new \DateTime();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string   
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    
    public function getCreatedOn(): \DateTime
    {
        return $this->createdOn;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdOn' => $this->createdOn->format(\DateTime::RFC3339),
        ];
    }
}