<?php

namespace Stamp\Action;

class VersionParser
{

    public function parse($version)
    {
        $regex = '/^(?P<major>\d+)\.(?P<minor>\d+)\.(?P<patch>\d+)$/';
        preg_match($regex, $version, $matches);
        unset($matches[0]);
        unset($matches[1]);
        unset($matches[2]);
        unset($matches[3]);
        return $matches;
    }
}
