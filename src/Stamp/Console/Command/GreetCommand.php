<?php

namespace Stamp\Console\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GreetCommand extends BaseCommand
{

    protected function configure()
    {
        $this
            ->setName('greet')
            ->setDescription('The prints a greeting.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $greeting = 'Hello';
        $output->writeln($greeting);
    }
}
