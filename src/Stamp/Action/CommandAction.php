<?php

namespace Stamp\Action;

use Stamp\Tools\VariableContainer;
use Symfony\Component\Process\Process;
use Twig_Loader_Array;
use Twig_Environment;

class CommandAction extends BaseAction implements ActionInterface
{
    private $commandTemplate;
    private $process;

    public function __construct(
        VariableContainer $variableContainer,
        Process $process
    ) {
        $this->variableContainer = $variableContainer;
        $this->process = $process;
    }

    public function getActionName()
    {
        return 'command';
    }

    public function setParams($array)
    {
        $this->setCommand($array['commandTemplate']);
    }

    public function setCommand($commandTemplate)
    {
        $this->commandTemplate = $commandTemplate;
    }

    public function exec()
    {
        $loader = new Twig_Loader_Array(array(
            'commandTemplate' => $this->commandTemplate,
        ));
        $twig = new Twig_Environment($loader);
        $command = $twig->render('commandTemplate', $this->variableContainer->getVariables());

        if ($this->verbose) {
            $this->setOutput(sprintf('command["%s"]', $command));
        }

        if (!$this->dryRun) {
            $this->process->setCommandLine($command);
            $this->process->run();
            if ($this->process->getOutput()) {
                return $this->process->getOutput();
            } else {
                return true;
            }
        }

        return true;
    }
}
