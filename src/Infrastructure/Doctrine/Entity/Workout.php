<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity;

use Carbon\CarbonImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Workout
{
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(type: 'carbon_immutable', nullable: false)]
    private CarbonImmutable $createdAt;

    #[ORM\Column(type: 'carbon_immutable', nullable: false)]
    private CarbonImmutable $endedAt;
}
