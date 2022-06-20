<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Exercise
{
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    /**
     * @var Collection<int, WorkoutExercice>
     */
    #[ORM\OneToMany(mappedBy: 'exercise', targetEntity: WorkoutExercice::class)]
    private Collection $workoutExercises;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->workoutExercises = new ArrayCollection();
    }
}
