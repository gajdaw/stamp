<?php

namespace Stamp\Action;

use Stamp\Tools\VersionParser;
use Stamp\Tools\VariableContainer;

class MinorUp extends BaseAction implements ActionInterface
{
    private $variable;

    private $versionParser;
    private $variableContainer;

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

    public function exec()
    {
        $var = $this->variableContainer->getVariable($this->variable);
        $parsed = $this->versionParser->parse($var);
        $increased = sprintf(
            '%s.%s.%s',
            $parsed['major'],
            ++$parsed['minor'],
            $parsed['patch']
        );
        if ($this->verbose) {
            $this->setOutput(sprintf(
                'minor_up["%s"="%s"]',
                $this->variable,
                $increased
            ));
        }
        $this->variableContainer->setVariable($this->variable, $increased);
        return true;
    }

}
