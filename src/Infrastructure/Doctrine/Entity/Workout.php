<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity;

use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Workout
{
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    /**
     * @var Collection<int, WorkoutExercice>
     */
    #[ORM\OneToMany(mappedBy: 'workout', targetEntity: WorkoutExercice::class)]
    private Collection $workoutExercises;

    #[ORM\Column(type: 'carbon_immutable', nullable: false)]
    private CarbonImmutable $createdAt;

    #[ORM\Column(type: 'carbon_immutable', nullable: false)]
    private CarbonImmutable $endedAt;

    public function __construct(int $id, CarbonImmutable $createdAt, CarbonImmutable $endedAt)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->endedAt = $endedAt;
        $this->workoutExercises = new ArrayCollection();
    }
}
