<?php

namespace Stamp\CommandRunner;

interface CommandRunnerInterface
{
    /**
     * @return array
     */
    public function getCommand();
    public function getRommands();
}
