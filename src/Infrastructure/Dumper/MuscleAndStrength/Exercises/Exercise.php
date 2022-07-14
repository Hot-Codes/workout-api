<?php

declare(strict_types=1);

namespace App\Infrastructure\Dumper\MuscleAndStrength\Exercises;

use DOMXPath;
use Symfony\Component\Console\Output\OutputInterface;

final class Exercise
{
    public function __construct(
    ) {
    }

    public static function fromXPath(DOMXPath $exerciseXPath, OutputInterface $output): void
    {
        $replaces = [' Instructions', ' Overview'];
        $exerciseName = str_replace($replaces, '', $exerciseXPath->query('//h2')->item(0)->textContent);

        $exerciseMuscleGroup = $exerciseXPath->query('//div[@class="field field-name-field-main-muscle field-type-taxonomy-term-reference field-label-hidden"]')->item(0)->textContent;
        $exerciseType = $exerciseXPath->query('//div[@class="node-stats-block"]/ul/li[2]')->item(0)->childNodes->item(1)->textContent;
        $exerciseEquipment = $exerciseXPath->query('//div[@class="node-stats-block"]/ul/li[3]')->item(0)->childNodes->item(1)->textContent;
        $exerciseMecanics = $exerciseXPath->query('//div[@class="node-stats-block"]/ul/li[4]')->item(0)->childNodes->item(1)->textContent;
        $exerciseForceType = $exerciseXPath->query('//div[@class="node-stats-block"]/ul/li[5]')->item(0)->childNodes->item(1)->textContent;
        $exerciseExperienceLevel = $exerciseXPath->query('//div[@class="node-stats-block"]/ul/li[6]')->item(0)->childNodes->item(1)->textContent;
        $exerciseSecondaryMuscleGroup = $exerciseXPath->query('//div[@class="node-stats-block"]/ul/li[7]')->item(0)->childNodes->item(1)->textContent;

        dump($exerciseMuscleGroup, $exerciseType, $exerciseEquipment, $exerciseMecanics, $exerciseForceType, $exerciseExperienceLevel, $exerciseSecondaryMuscleGroup);

        $output->writeln(sprintf('    » <fg=green>%s</> dumped !', $exerciseName));
    }
}
