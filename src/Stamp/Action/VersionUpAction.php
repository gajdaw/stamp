<?php

namespace Stamp\Action;

use Stamp\Tools\VersionParser;
use Stamp\Tools\VariableContainer;

abstract class VersionUpAction extends BaseAction implements ActionInterface
{
    protected $variable;
    protected $parsed;

    protected $versionParser;
    protected $variableContainer;

    public function __construct(VariableContainer $variableContainer, VersionParser $versionParser)
    {
        $this->variableContainer = $variableContainer;
        $this->versionParser = $versionParser;
    }

    public function setParams($array)
    {
        $this->setVariable($array['variable']);
    }

    public function setVariable($variable)
    {
        $this->variable = $variable;
    }

    abstract function increaseVersion();

    public function generateVerboseOutput()
    {
        if ($this->verbose) {
            $this->setOutput(sprintf(
                $this->getActionName() .
                '["%s"="%s"]',
                $this->variable,
                $this->increased
            ));
        }
    }

    public function exec()
    {
        $var = $this->variableContainer->getVariable($this->variable);
        $this->parsed = $this->versionParser->parse($var);
        $this->increaseVersion();
        $this->generateVerboseOutput();
        $this->variableContainer->setVariable($this->variable, $this->increased);
        return true;
    }

}
