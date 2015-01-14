<?php

namespace Stamp\Action;

use Stamp\Tools\VersionParser;
use Stamp\Tools\VariableContainer;

class MinorUp extends VersionUpAction implements ActionInterface
{
    public function getActionName()
    {
        return 'minor_up';
    }

    public function increaseVersion()
    {
        $this->increased = sprintf(
            '%s.%s.%s',
            $this->parsed['major'],
            ++$this->parsed['minor'],
            0
        );
    }

}

