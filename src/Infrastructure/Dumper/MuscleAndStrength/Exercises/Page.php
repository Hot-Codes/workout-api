<?php

declare(strict_types=1);

namespace App\Infrastructure\Dumper\MuscleAndStrength\Exercises;

use DomDocument;
use DOMNamedNodeMap;
use DOMNodeList;
use DOMXpath;
use Exception;
use Symfony\Component\Console\Output\OutputInterface;

final class Page
{
    public function __construct(
        private readonly DOMNodeList $exercises,
        private readonly string $defaultUrl,
    ) {
    }

    public function dump(OutputInterface $output): void
    {
        for ($exerciseCount = 0; $exerciseCount < $this->exercises->count(); ++$exerciseCount) {
            if ($this->exercises->item($exerciseCount) === null) {
                continue;
            }

            $currentExercise = $this->exercises->item($exerciseCount);
            if ($currentExercise->childNodes->item(1) === null) {
                continue;
            }

            $divNode = $currentExercise->childNodes->item(1);
            if ($divNode === null) {
                continue;
            }

            $linkNode = $divNode->childNodes->item(1);
            if ($linkNode === null) {
                continue;
            }

            /** @var DOMNamedNodeMap $linkAttributeMap */
            $linkAttributeMap = $linkNode->attributes;

            $linkNodeAttribute = $linkAttributeMap->getNamedItem('href');
            if ($linkNodeAttribute === null) {
                continue;
            }

            if ($linkNodeAttribute->nodeValue === null) {
                continue;
            }

            $exerciseUrl = $this->defaultUrl . substr($linkNodeAttribute->nodeValue, 10);
            try {
                $exercisePageContent = $this->getPageContent($exerciseUrl);

                $exercisePageXPath = new DOMXpath($exercisePageContent);
                Exercise::fromXPath($exercisePageXPath, $output);
            } catch (Exception $e) {
                $output->writeln(sprintf("Can't dump exercise from %s", $exerciseUrl));
                throw new Exception(sprintf("Can't dump exercise from %s", $exerciseUrl));
            }
        }
    }

    /**
     * @throws Exception
     */
    private function getPageContent(string $url): DOMDocument
    {
        $internalErrors = libxml_use_internal_errors(true);

        /** @var non-empty-string $pageContent */
        $pageContent = file_get_contents($url);

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->loadHTML($pageContent);

        libxml_use_internal_errors($internalErrors);

        return $dom;
    }
}
