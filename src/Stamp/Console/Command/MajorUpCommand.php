<?php

namespace Stamp\Console\Command;

class MajorUpCommand extends BaseIncreaseVersionCommand
{

    protected function configure()
    {
        $this
            ->setName('major:up')
            ->setDescription('The command to increase a patch number.');

        $this->addGenericOptions();
    }

    protected function getActions()
    {
        return array(
            array(
                'name' => 'major_up',
                'parameters' => array(
                    'variable' => $this->config['variable'],
                )
            ),
        );
    }

}
