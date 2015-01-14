<?php

namespace Stamp\Console\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class PatchUpCommand extends BaseCommand
{

    protected function configure()
    {
        $this
            ->setName('patch:up')
            ->setDescription('The command to increase a patch number.')
            ->addOption(
                'dry-run',
                null,
                InputOption::VALUE_OPTIONAL,
                'Should the command run in dry mode?'
            );
    }

    public function getDefaultValue(InputInterface $input, $name, $default = false)
    {
        $result = $default;
        if ($input->getOption($name)) {
            $result = $input->getOption($name);
        }

        return $result;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dryRun = $this->getDefaultValue($input, 'dry-run');
        $verbose = $this->getDefaultValue($input, 'verbose');

        $container = $this->getApplication()->getContainer();
        $config = $this->getApplication()->getConfig();

        $actions = array(
            array(
                'name' => 'parse_variable_from_file',
                'parameters' => array(
                    'filename' => $config['filename'],
                    'regex' => $config['regex'],
                )
            ),
            array(
                'name' => 'patch_up',
                'parameters' => array(
                    'variable' => $config['variable'],
                )
            ),
            array(
                'name' => 'save_variable_to_file',
                'parameters' => array(
                    'filename' => $config['filename'],
                    'variable' => $config['variable'],
                    'src'      => $config['regex'],
                    'dest'     => $config['replacement'],
                )
            ),
            array(
                'name' => 'command',
                'parameters' => array(
                    'commandTemplate' => 'git add ' . $config['filename'],
                )
            ),
            array(
                'name' => 'command',
                'parameters' => array(
                    'commandTemplate' => 'git commit -m "Version {{ version }}"',
                )
            ),
            array(
                'name' => 'command',
                'parameters' => array(
                    'commandTemplate' => 'git tag -a v{{ version }} -m "Release {{ version }}"',
                )
            ),
        );

        foreach ($actions as $action) {
            $executor = $container->get('stamp.actions.' . $action['name']);
            $executor->setParams($action['parameters']);
            $executor->setVerbose($verbose);
            $executor->setDryRun($dryRun);
            $executor->exec();
            if ($verbose) {
                $output->writeln($executor->getOutput());
            }
        }
    }
}
