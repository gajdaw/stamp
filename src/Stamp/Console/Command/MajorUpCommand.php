<?php

namespace Stamp\Console\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MajorUpCommand extends BaseIncreaseVersionCommand
{

    protected function configure()
    {
        $this
            ->setName('major:up')
            ->setDescription('The command to increase a patch number.')
            ->addOption(
                'dry-run',
                null,
                InputOption::VALUE_OPTIONAL,
                'Should the command run in dry mode?'
            );
    }

    protected function getActions()
    {
        return array(
            array(
                'name' => 'major_up',
                'parameters' => array(
                    'variable' => $this->config['variable'],
                )
            ),
        );
    }

}
