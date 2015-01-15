<?php

namespace Stamp\Action;

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
