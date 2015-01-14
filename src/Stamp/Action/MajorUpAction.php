<?php

namespace Stamp\Action;

use Stamp\Tools\VersionParser;
use Stamp\Tools\VariableContainer;

class MajorUpAction extends VersionUpAction implements ActionInterface
{
    public function getActionName()
    {
        return 'major_up';
    }

    public function increaseVersion()
    {
        $this->increased = sprintf(
            '%s.%s.%s',
            ++$this->parsed['major'],
            0,
            0
        );
    }

}
