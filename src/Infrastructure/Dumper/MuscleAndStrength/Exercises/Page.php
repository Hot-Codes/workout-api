<?php

declare(strict_types=1);

namespace App\Infrastructure\Dumper\MuscleAndStrength\Exercises;

use DOMNamedNodeMap;
use DOMNodeList;

final class Page
{
    public function __construct(
        private readonly DOMNodeList $exercises,
        private readonly string $defaultUrl,
    ) {
    }

    public function dump(): void
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

            dump($exerciseUrl);
        }
    }
}
