<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class WorkoutExercice
{
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Workout::class)]
    private Workout $workout;

    #[ORM\ManyToOne(targetEntity: Exercise::class)]
    private Exercise $exercise;

    /**
     * @var Collection<int, Repetition>
     */
    #[Orm\OneToMany(mappedBy: 'workoutExercice', targetEntity: Repetition::class)]
    private Collection $repetitions;

    public function __construct(int $id, Workout $workout, Exercise $exercise)
    {
        $this->id = $id;
        $this->workout = $workout;
        $this->exercise = $exercise;
        $this->repetitions = new ArrayCollection();
    }
}
