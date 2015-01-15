<?php

namespace Stamp\Tools;

use Symfony\Component\Process\Exception\RuntimeException;

class VersionParser
{

    public function parse($version)
    {
        $regex = '/^(?P<major>\d+)\.(?P<minor>\d+)\.(?P<patch>\d+)$/';
        if (!preg_match($regex, $version, $matches)) {
            throw new RuntimeException(sprintf(
                'Version "%s" doesnt match x.x.x!',
                $version
            ));
        }
        unset($matches[0]);
        unset($matches[1]);
        unset($matches[2]);
        unset($matches[3]);

        return $matches;
    }
}
