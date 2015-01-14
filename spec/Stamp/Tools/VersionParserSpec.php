<?php

namespace spec\Stamp\Tools;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Process\Exception\RuntimeException;

class VersionParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Stamp\Tools\VersionParser');
    }
    function it_should_parse_version()
    {
        $tmpVersion = '6543.7421.9655';
        $this->parse($tmpVersion)->shouldReturn(array(
            'major' => '6543', 'minor' => '7421', 'patch' => '9655'
        ));
    }
    function it_should_exept_for_incorrect_version()
    {
        $tmpVersion = '5';
        $this->shouldThrow(
            new RuntimeException(sprintf(
                'Version "%s" doesnt match x.x.x!',
                $tmpVersion
            ))
        )->duringParse($tmpVersion);
    }
}
