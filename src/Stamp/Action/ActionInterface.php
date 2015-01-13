<?php

namespace Stamp\Action;

interface ActionInterface
{
    public function setParams($array);
    public function exec();
    public function getResult();
    public function getOutput();
    public function setVerbose($verbose);
    public function setDryRun($dryRun);
}
