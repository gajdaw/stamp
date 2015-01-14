<?php

namespace Stamp\Console\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class PatchUpCommand extends BaseIncreaseVersionCommand
{

    protected function configure()
    {
        $this
            ->setName('patch:up')
            ->setDescription('The command to increase a patch number.')
            ->addOption(
                'dry-run',
                null,
                InputOption::VALUE_NONE,
                'Should the command run in dry mode?'
            );
    }

    protected function getActions()
    {
        return array(
            array(
                'name' => 'patch_up',
                'parameters' => array(
                    'variable' => $this->config['variable'],
                )
            ),
        );
    }

}
