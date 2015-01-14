<?php

namespace Stamp\Console\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use RuntimeException;

abstract class BaseIncreaseVersionCommand extends BaseCommand
{
    protected $config;
    protected $container;
    protected $verbose;
    protected $dry_run;

    public function validateConfig()
    {
        $keys = array_keys($this->config);
        if (!in_array('filename', $keys)) {
            throw new RuntimeException('Cannot find "filename" entry in config file!');
        }
        if (!in_array('regex', $keys)) {
            throw new RuntimeException('Cannot find "regex" entry in config file!');
        }
        if (!in_array('replacement', $keys)) {
            throw new RuntimeException('Cannot find "replacement" entry in config file!');
        }
    }

    public function addGenericOptions()
    {
        $this
            ->addOption(
                'dry-run',
                null,
                InputOption::VALUE_NONE,
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

    protected function getPreActions()
    {
        return array(
            array(
                'name' => 'parse_variable_from_file',
                'parameters' => array(
                    'filename' => $this->config['filename'],
                    'regex' => $this->config['regex'],
                )
            )
        );
    }

    protected function getActions()
    {
        return array();
    }

    protected function getPostActions()
    {
        return array(
            array(
                'name' => 'save_variable_to_file',
                'parameters' => array(
                    'filename' => $this->config['filename'],
                    'variable' => $this->config['variable'],
                    'src'      => $this->config['regex'],
                    'dest'     => $this->config['replacement'],
                )
            ),
            array(
                'name' => 'command',
                'parameters' => array(
                    'commandTemplate' => 'git add ' . $this->config['filename'],
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
            )
        );
    }

    public function runActions($actions, OutputInterface $output)
    {
        foreach ($actions as $action) {
            $executor = $this->container->get('stamp.actions.' . $action['name']);
            $executor->setParams($action['parameters']);
            $executor->setVerbose($this->verbose);
            $executor->setDryRun($this->dryRun);
            $executor->exec();
            if ($this->verbose) {
                $output->writeln($executor->getOutput());
            }
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->dryRun = $this->getDefaultValue($input, 'dry-run');
        $this->verbose = $this->getDefaultValue($input, 'verbose');

        $this->container = $this->getApplication()->getContainer();
        $this->config = $this->getApplication()->getConfig();

        $this->validateConfig();

        $this->runActions($this->getPreActions(), $output);
        $this->autoSetVariable();
        $this->runActions($this->getActions(), $output);
        $this->runActions($this->getPostActions(), $output);
    }

    public function autoSetVariable()
    {
        $variableContainer = $this->container->get('stamp.actions.variable_container');
        $this->config['variable'] = $variableContainer->getFirstVariableName();
    }
}
