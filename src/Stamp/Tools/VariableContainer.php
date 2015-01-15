<?php

namespace Stamp\Tools;

class VariableContainer
{
    private $variables;

    public function __construct()
    {
        $this->variables = array();
    }

    public function setVariable($name, $value)
    {
        $this->variables[$name] = $value;
    }

    public function getVariable($name)
    {
        if (!in_array($name, array_keys($this->variables))) {
            throw new \RuntimeException(sprintf(
                'Variable "%s" not found in the container.',
                $name
            ));
        }

        return $this->variables[$name];
    }

    public function getVariables()
    {
        return $this->variables;
    }

    public function getFirstVariableName()
    {
        $names = array_keys($this->variables);

        return $names[0];
    }
}
