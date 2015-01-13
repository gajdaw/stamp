<?php

namespace spec\Stamp\Tools;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VariableContainerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Stamp\Tools\VariableContainer');
    }
    function it_should_store_var()
    {
        $this->setVariable('abc', 123);
        $this->getVariable('abc')->shouldReturn(123);
    }
    function it_should_store_var_set_multiple_times()
    {
        $this->setVariable('abc', 123);
        $this->setVariable('abc', 'lorem');
        $this->setVariable('abc', 'ipsum');
        $this->getVariable('abc')->shouldReturn('ipsum');
    }
    function it_should_throw_exception_when_var_doesnt_exist()
    {
        $this->shouldThrow(
            new \RuntimeException('Variable "abc" not found in the container.')
        )->duringGetVariable('abc');
    }

}
