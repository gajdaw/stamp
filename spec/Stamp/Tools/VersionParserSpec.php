<?php

namespace spec\Stamp\Tools;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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
}
