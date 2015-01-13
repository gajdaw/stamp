<?php

namespace Stamp\Action;

class MajorUp
{
    private $variable;

    private $versionParser;
    private $variableContainer;

    public function __construct(VersionParser $versionParser, VariableContainer $variableContainer)
    {
        $this->versionParser = $versionParser;
        $this->variableContainer = $variableContainer;
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
            ++$parsed['major'],
            $parsed['minor'],
            $parsed['patch']
        );
        $this->variableContainer->setVariable($this->variable, $increased);
        return true;
    }

}
