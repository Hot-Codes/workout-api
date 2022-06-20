<?php

namespace App\Controller\Home;

use App\Infrastructure\Doctrine\Entity\Exercise;
use App\Infrastructure\Doctrine\Entity\Workout;
use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }


    public function home(): Response
    {
        $exercise = new Exercise(1, "Bench press");
        $this->entityManager->persist($exercise);

        $workout = new Workout(1000, CarbonImmutable::now(), CarbonImmutable::now());
        $this->entityManager->persist($workout);

        $this->entityManager->flush();

        return new JsonResponse(["state" => "OK"]);
    }
}