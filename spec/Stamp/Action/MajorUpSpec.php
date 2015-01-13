<?php

namespace spec\Stamp\Action;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Stamp\Action\VersionParser;
use Stamp\Action\VariableContainer;


class MajorUpSpec extends ObjectBehavior
{
    function let(VersionParser $versionParser, VariableContainer $variableContainer)
    {
        $this->beConstructedWith($versionParser, $variableContainer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Stamp\Action\MajorUp');
    }
    function it_should_parse_version(VersionParser $versionParser, VariableContainer $variableContainer)
    {
        $tmpVersion = '3.421.55';

        $variableContainer->getVariable('version')->willReturn('3.421.55');
        $variableContainer->setVariable('version', '4.421.55')->shouldBeCalled();

        $versionParser->parse($tmpVersion)->willReturn(array(
           'major' => '3', 'minor' => '421', 'patch' => '55'
        ));

        $params = array(
            'variable'  => 'version'
        );
        $this->setVerbose(true);
        $this->setParams($params);
        $this->exec()->shouldReturn(true);
        $this->getOutput()->shouldReturn('increase_major_version["version"="4.421.55"]');
    }
}
