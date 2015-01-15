<?php

namespace Stamp\Console\Command;

class MinorUpCommand extends BaseIncreaseVersionCommand
{

    protected function configure()
    {
        $this
            ->setName('minor:up')
            ->setDescription('The command to increase a patch number.');

        $this->addGenericOptions();
    }

    protected function getActions()
    {
        return array(
            array(
                'name' => 'minor_up',
                'parameters' => array(
                    'variable' => $this->config['variable'],
                )
            ),
        );
    }

}
