<?php

namespace spec\Stamp\Action;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Stamp\Tools\VariableContainer;
use Symfony\Component\Process\Process;

class CommandActionSpec extends ObjectBehavior
{
    function let(
        VariableContainer $variableContainer,
        Process $process
    ) {
        $this->beConstructedWith(
            $variableContainer,
            $process
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Stamp\Action\CommandAction');
    }

    function it_should_run_a_command_in_verbose_mode(
        VariableContainer $variableContainer,
        Process $process
    ) {
        $params = array(
            'commandTemplate' => 'echo "Version {{ no }}"',
        );
        $variableContainer->getVariables()->willReturn(array('no' => '9.8.7'));
        $process->setCommandLine('echo "Version 9.8.7"')->shouldBeCalled();
        $process->run()->shouldBeCalled();
        $process->getOutput()->shouldBeCalled();

        $this->setParams($params);
        $this->setVerbose(true);

        $this->exec()->shouldReturn(true);
        $this->getResult()->shouldReturn(null);
        $this->getOutput()->shouldReturn('command["echo "Version 9.8.7""]');
    }

    function it_should_not_run_command_in_dry_mode(
        VariableContainer $variableContainer,
        Process $process
    ) {
        $params = array(
            'commandTemplate' => 'echo "Hello, {{ subjectOfGreeting }}"',
        );
        $variableContainer->getVariables()->willReturn(array('subjectOfGreeting' => 'WORLD'));
        $process->setCommandLine('echo "Hello, WORLD"')->shouldNotBeCalled();
        $process->disableOutput()->shouldNotBeCalled();
        $process->run()->shouldNotBeCalled();
        $process->getExitCode()->shouldNotBeCalled();

        $this->setParams($params);
        $this->setVerbose(true);
        $this->setDryRun(true);

        $this->exec()->shouldReturn(true);
        $this->getResult()->shouldReturn(null);
        $this->getOutput()->shouldReturn('command["echo "Hello, WORLD""]');
    }

}
