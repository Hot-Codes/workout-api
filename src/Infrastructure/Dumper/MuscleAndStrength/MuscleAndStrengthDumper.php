<?php

declare(strict_types=1);

namespace App\Infrastructure\Dumper\MuscleAndStrength;

use DOMDocument;
use DOMXpath;
use Exception;
use Symfony\Component\Console\Output\OutputInterface;

final class MuscleAndStrengthDumper
{
    private const DEFAULT_URL = 'https://www.muscleandstrength.com/exercises';

    public function dump(OutputInterface $output): void
    {
        $output->writeln("Dumping all exercises from www.muscleandstrength.com");
        // $this->dumpMuscleExercises('abductors', $output);
        $this->dumpMuscleExercises('abs', $output);
//        $this->dumpMuscleExercises('Adductors', $output);
        $this->dumpMuscleExercises('biceps', $output);
//        $this->dumpMuscleExercises('Calves', $output);
//        $this->dumpMuscleExercises('Chest', $output);
//        $this->dumpMuscleExercises('Forearms', $output);
//        $this->dumpMuscleExercises('Glutes', $output);
//        $this->dumpMuscleExercises('Hamstrings', $output);
//        $this->dumpMuscleExercises('Hip Flexors', $output);
//        $this->dumpMuscleExercises('IT Band', $output);
//        $this->dumpMuscleExercises('Lats', $output);
//        $this->dumpMuscleExercises('Lower Back', $output);
//        $this->dumpMuscleExercises('Upper Back', $output);
//        $this->dumpMuscleExercises('Neck', $output);
//        $this->dumpMuscleExercises('Obliques', $output);
//        $this->dumpMuscleExercises('Palmar Fascia', $output);
//        $this->dumpMuscleExercises('Plantar Fascia', $output);
//        $this->dumpMuscleExercises('Quads', $output);
//        $this->dumpMuscleExercises('Shoulders', $output);
//        $this->dumpMuscleExercises('Traps', $output);
//        $this->dumpMuscleExercises('Triceps', $output);
    }

    private function dumpMuscleExercises(string $muscle, OutputInterface $output): void
    {
        $output->writeln("Dumping " . $muscle . '...');
        try {
            $currentPageUrl = self::DEFAULT_URL . '/' . $muscle . '?page=0&ajax=1';
            $firstPageDom = $this->getPageContent($currentPageUrl);

            $xpath = new DOMXpath($firstPageDom);
            $exercises = $xpath->query('//div[@class = "cell small-12 bp600-6"]');

            $lastPageNodes = $xpath->query('//a[@title = "Go to last page"]');
            
            $lastPageUrl = $lastPageNodes->item(0)->attributes->getNamedItem('href')->nodeValue;
            $lastPageNumber = (int) explode("&page=", $lastPageUrl)[1];


        } catch (Exception $e) {
            $output->writeln("Can't dump " . $muscle . ' !');
            $output->writeln($e->getMessage() . '\n');
        }
    }

    private function getPageContent(string $url): DOMDocument
    {
        /** @var {string view} $pageContent */
        $pageContent = json_decode(file_get_contents($url));

        $dom = new DOMDocument();
        $dom->loadHTML($pageContent->view);

        return $dom;
    }
}
