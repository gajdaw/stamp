<?php

namespace Stamp\Action;

use Stamp\Tools\VersionParser;
use Stamp\Tools\VariableContainer;

class MajorUp
{
    private $variable;

    private $versionParser;
    private $variableContainer;

    private $result;
    private $output;
    private $verbose = false;


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
        if ($this->verbose) {
            $this->output = sprintf(
                'major_up["%s"="%s"]',
                $this->variable,
                $increased
            );
        }
        $this->variableContainer->setVariable($this->variable, $increased);
        return true;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setVerbose($verbose)
    {
        $this->verbose = $verbose;
    }



}
