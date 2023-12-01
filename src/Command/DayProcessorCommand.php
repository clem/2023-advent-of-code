<?php

declare(strict_types=1);

namespace App\Command;

use App\Exception\DayNotFoundException;
use App\UseCase\DayProcessorInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:day:process',
    description: 'Process a day.',
    aliases: ['app:process-day'],
    hidden: false
)]
final class DayProcessorCommand extends Command
{
    private SymfonyStyle $io;

    protected function configure(): void
    {
        $this->addArgument('day', InputArgument::REQUIRED, 'Day to process.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);
        $day = (int) $input->getArgument('day');

        try {
            $this->processDay($day);
        } catch (\Throwable $exception) {
            $this->io->error($exception->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function processDay(int $day): void
    {
        try {
            $processor = $this->getProcessor($day);
        } catch (\RuntimeException $e) {
            throw new DayNotFoundException($day);
        }

        $this->io->title(sprintf('Day %02d process output', $day));
        $input = $this->getInputFileContents($day);

        $startTime = microtime(true);

        $this->processDayPart($processor, $input, 'one');
        $this->io->newLine();
        $this->processDayPart($processor, $input, 'two');

        $this->io->info(sprintf(
            'Day %02d processed in %.2f seconds',
            $day,
            microtime(true) - $startTime
        ));
    }

    private function getProcessor(int $day): DayProcessorInterface
    {
        $processorClass = sprintf('App\UseCase\Day%1$02d\Day%1$02dProcessor', $day);
        if (!class_exists($processorClass)) {
            throw new \RuntimeException(sprintf(
                'Processor class %s does not exist!',
                $processorClass
            ));
        }

        return new $processorClass();
    }

    private function processDayPart(DayProcessorInterface $processor, string $input, string $part): void
    {
        if (!in_array($part, ['one', 'two'])) {
            throw new \InvalidArgumentException(sprintf('Invalid part %s!', $part));
        }

        $startTime = microtime(true);
        $partResult = $processor->{'processPart'.ucfirst($part)}($input);
        $this->io->writeln('Part '.$part.': '.$partResult);
        $this->io->writeln(sprintf(
                'Processed in %.2f seconds',
                microtime(true) - $startTime)
        );
    }

    private function getInputFileContents(int $day): string
    {
        $inputFolder = realpath(sprintf('%s/../../input', __DIR__));
        $inputFile = sprintf('%s/day%02d.txt', $inputFolder, $day);
        if (!file_exists($inputFile)) {
            throw new \RuntimeException(sprintf('Input file %s does not exist!', $inputFile));
        }

        $content = file_get_contents($inputFile);
        if ($content === false) {
            throw new \RuntimeException(sprintf('Could not read input file %s!', $inputFile));
        }

        return trim($content);
    }
}
