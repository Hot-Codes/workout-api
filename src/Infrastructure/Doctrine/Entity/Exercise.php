<?php

namespace App\Infrastructure\Doctrine\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping AS ORM;

#[ORM\Entity]
class Exercise
{
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(type: Types::STRING)]
    private string $name;
}