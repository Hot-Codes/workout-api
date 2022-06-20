<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity;

use App\Infrastructure\Doctrine\Enums\MassUnitEnum;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Repetition
{
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(type: Types::INTEGER)]
    private int $number;

    #[ORM\Column(type: Types::INTEGER)]
    private int $weight;

    #[ORM\Column(type: Types::STRING, enumType: MassUnitEnum::class)]
    private MassUnitEnum $massUnit;

    #[ORM\ManyToOne(targetEntity: WorkoutExercice::class)]
    private WorkoutExercice $workoutExercise;

    public function __construct(int $id, WorkoutExercice $workoutExercise, int $number, int $weight)
    {
        $this->id = $id;
        $this->workoutExercise = $workoutExercise;
        $this->number = $number;
        $this->weight = $weight;
    }
}
