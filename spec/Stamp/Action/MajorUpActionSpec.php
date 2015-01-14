<?php

namespace spec\Stamp\Action;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Stamp\Tools\VersionParser;
use Stamp\Tools\VariableContainer;


class MajorUpActionSpec extends ObjectBehavior
{
    function let(VariableContainer $variableContainer, VersionParser $versionParser)
    {
        $this->beConstructedWith($variableContainer, $versionParser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Stamp\Action\MajorUpAction');
    }
    function it_should_parse_version(VariableContainer $variableContainer, VersionParser $versionParser)
    {
        $tmpVersion = '3.421.55';

        $variableContainer->getVariable('version')->willReturn('3.421.55');
        $variableContainer->setVariable('version', '4.0.0')->shouldBeCalled();

        $versionParser->parse($tmpVersion)->willReturn(array(
           'major' => '3', 'minor' => '421', 'patch' => '55'
        ));

        $params = array(
            'variable'  => 'version'
        );
        $this->setVerbose(true);
        $this->setParams($params);
        $this->exec()->shouldReturn(true);
        $this->getOutput()->shouldReturn('major_up["version"="4.0.0"]');
    }
}
