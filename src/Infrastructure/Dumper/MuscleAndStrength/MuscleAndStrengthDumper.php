<?php

declare(strict_types=1);

namespace App\Infrastructure\Dumper\MuscleAndStrength;

use App\Infrastructure\Dumper\MuscleAndStrength\Exercises\Page;
use DOMDocument;
use DOMNamedNodeMap;
use DOMXpath;
use Exception;
use Symfony\Component\Console\Output\OutputInterface;

final class MuscleAndStrengthDumper
{
    private const DEFAULT_URL = 'https://www.muscleandstrength.com/exercises';

    public function dump(OutputInterface $output): void
    {
        $output->writeln('Dumping all exercises from www.muscleandstrength.com');
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
        $output->writeln(sprintf('  » Dumping <fg=red>%s</>...', $muscle));
        try {
            $currentPageUrl = self::DEFAULT_URL . '/' . $muscle . '?page=0&ajax=1';
            $firstPageDom = $this->getPageContent($currentPageUrl);
            $firstPageXPath = new DOMXpath($firstPageDom);
            $lastPageNumber = $this->getLastPage($firstPageXPath) + 1;

            for ($pageCount = 0; $pageCount < $lastPageNumber; ++$pageCount) {
                $currentPageXPath = new DOMXpath(
                    $this->getPageContent(self::DEFAULT_URL . '/' . $muscle . '?page=' . $pageCount . '&ajax=1'),
                );
                $exercises = $currentPageXPath->query('//div[@class = "cell small-12 bp600-6"]');

                $page = new Page($exercises, self::DEFAULT_URL);
                $page->dump($output);
            }
        } catch (Exception $e) {
            $output->writeln("Can't dump " . $muscle . ' !');
            $output->writeln($e->getMessage() . '\n');
        }
    }

    /**
     * @throws Exception
     */
    private function getPageContent(string $url): DOMDocument
    {
        /** @var object $pageContent */
        $pageContent = json_decode(file_get_contents($url));
        /** @var string $pageContentView */
        $pageContentView = $pageContent->view;

        if (empty($pageContentView)) {
            throw new Exception(sprintf('PageContent[view] cannot be find from %s', $url));
        }

        $dom = new DOMDocument();
        $dom->loadHTML($pageContentView);

        return $dom;
    }

    private function getLastPage(DOMXpath $xpath): int
    {
        $lastPageNodes = $xpath->query('//a[@title = "Go to last page"]');

        if ($lastPageNodes->item(0) === null) {
            return 0;
        }

        /** @var DOMNamedNodeMap $lastPageNodeAttributesMap */
        $lastPageNodeAttributesMap = $lastPageNodes->item(0)->attributes;

        if ($lastPageNodeAttributesMap->getNamedItem('href') === null) {
            return 0;
        }

        $lastPageHref = $lastPageNodeAttributesMap->getNamedItem('href');

        if ($lastPageHref === null || $lastPageHref->nodeValue === null) {
            return 0;
        }

        $lastPageUrl = $lastPageHref->nodeValue;

        return (int) explode('&page=', $lastPageUrl)[1];
    }
}
