<?php

namespace Stamp\Action;

abstract class BaseAction
{
    protected $result;
    protected $output;
    protected $verbose = false;
    protected $dryRun = false;

    abstract public function getActionName();

    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result)
    {
        $this->result = $result;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setOutput($output)
    {
        $this->output = $output;
    }

    public function setVerbose($verbose)
    {
        $this->verbose = $verbose;
    }

    public function setDryRun($dryRun)
    {
        $this->dryRun = $dryRun;
    }

}
