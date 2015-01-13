<?php

namespace Stamp\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Stamp\Console\Command\PatchUpCommand;

/**
 * The command line application entry point
 */
class Application extends BaseApplication
{
    /**
     * @param string $version
     */
    public function __construct($version = '0.1-dev')
    {
        parent::__construct('stamp', $version);

        $this->add(new PatchUpCommand());
    }
}
