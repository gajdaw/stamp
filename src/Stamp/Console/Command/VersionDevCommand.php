<?php

namespace Stamp\Console\Command;

class VersionDevCommand extends BaseIncreaseVersionCommand
{

    protected function configure()
    {
        $this
            ->setName('version:dev')
            ->setDescription('The command to set version to git describe.');

        $this->addGenericOptions();
    }

    protected function getActions()
    {
        return array(
            array(
                'name' => 'set_variable_from_git_describe',
                'parameters' => array(
                )
            ),
        );
    }

}
