<?php

namespace spec\Stamp\Action;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Stamp\Tools\VariableContainer;
use Stamp\Action\CommandAction;


class SetVariableFromGitDescribeSpec extends ObjectBehavior
{
    function let(
        VariableContainer $variableContainer,
        CommandAction $commandAction
    ) {
        $this->beConstructedWith(
            $variableContainer,
            $commandAction
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Stamp\Action\SetVariableFromGitDescribe');
    }

    function it_should_set_version_to_git_describe(
        VariableContainer $variableContainer,
        CommandAction $commandAction
    ) {
        $commandAction->exec()->willReturn('1.2.6-77-abcd');
        $commandAction->setCommand('git describe')->shouldBeCalled();
        $variableContainer->setVariable('version', '1.2.6-77-abcd')->shouldBeCalled();
        $this->exec()->shouldReturn(true);
    }

}
