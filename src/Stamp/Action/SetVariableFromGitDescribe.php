<?php

namespace Stamp\Action;

use Stamp\Tools\VariableContainer;
use Stamp\Action\CommandAction;

class SetVariableFromGitDescribe extends BaseAction implements ActionInterface
{
    private $variableContainer;
    private $commandAction;

    public function __construct(
        VariableContainer $variableContainer,
        CommandAction $commandAction
    ) {
        $this->variableContainer = $variableContainer;
        $this->commandAction = $commandAction;
    }

    public function getActionName()
    {
        return 'set_variable_from_git_describe';
    }

    public function exec()
    {
        $this->commandAction->setCommand('git describe');
        $outputOfGitDescribe = $this->commandAction->exec();
        $this->variableContainer->setVariable('version', $outputOfGitDescribe);
        return true;
    }

    public function setParams($array)
    {
    }

}
