<?php

namespace spec\Stamp\Action;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Stamp\Tools\VersionParser;
use Stamp\Tools\VariableContainer;


class MinorUpActionSpec extends ObjectBehavior
{
    function let(VariableContainer $variableContainer, VersionParser $versionParser)
    {
        $this->beConstructedWith($variableContainer, $versionParser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Stamp\Action\MinorUpAction');
    }
    function it_should_parse_version(VariableContainer $variableContainer, VersionParser $versionParser)
    {
        $tmpVersion = '3.421.55';

        $variableContainer->getVariable('version')->willReturn('3.421.55');
        $variableContainer->setVariable('version', '3.422.0')->shouldBeCalled();

        $versionParser->parse($tmpVersion)->willReturn(array(
           'major' => '3', 'minor' => '421', 'patch' => '55'
        ));

        $params = array(
            'variable'  => 'version'
        );
        $this->setVerbose(true);
        $this->setParams($params);
        $this->exec()->shouldReturn(true);
        $this->getOutput()->shouldReturn('minor_up["version"="3.422.0"]');
    }
}
