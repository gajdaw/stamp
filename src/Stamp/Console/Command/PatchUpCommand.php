<?php

namespace Stamp\Console\Command;

class PatchUpCommand extends BaseIncreaseVersionCommand
{

    protected function configure()
    {
        $this
            ->setName('patch:up')
            ->setDescription('The command to increase a patch number.');

        $this->addGenericOptions();
    }

    protected function getActions()
    {
        return array(
            array(
                'name' => 'patch_up',
                'parameters' => array(
                    'variable' => $this->config['variable'],
                )
            ),
        );
    }

}
