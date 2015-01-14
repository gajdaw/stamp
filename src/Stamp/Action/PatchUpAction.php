<?php

namespace Stamp\Action;

use Stamp\Tools\VersionParser;
use Stamp\Tools\VariableContainer;

class PatchUpAction extends VersionUpAction implements ActionInterface
{
    public function getActionName()
    {
        return 'patch_up';
    }

    public function increaseVersion()
    {
        $this->increased = sprintf(
            '%s.%s.%s',
            $this->parsed['major'],
            $this->parsed['minor'],
            ++$this->parsed['patch']
        );
    }

}
