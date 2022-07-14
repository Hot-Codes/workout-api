<?php

declare(strict_types=1);

namespace App\UI\Commands\DumpExercisesDatabase;

use App\Infrastructure\Dumper\MuscleAndStrength\MuscleAndStrengthDumper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpExercisesDatabaseCommand extends Command
{
    public function __construct(
        private readonly MuscleAndStrengthDumper $muscleAndStrengthDumper,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('dump:exercises:ms');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ini_set('user_agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36 Edg/103.0.1264.49');

        $this->muscleAndStrengthDumper->dump($output);

        return 0;
    }
}
