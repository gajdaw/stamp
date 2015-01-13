<?php

namespace spec\Stamp\Action;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParseVariableSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('Stamp\Action\ParseVariable');
    }

    function it_should_parse_a_variable()
    {
        $text = '
            {
                "lorem": "1.2.3.4"
            }
        ';
        $regex = '/"lorem": *"(?P<NAME>[^"]+)"/';
        $this->setText($text);
        $this->setRegex($regex);
        $this->exec()->shouldReturn(array('NAME' => '1.2.3.4'));
    }

    function it_should_parse_using_params()
    {
        $params = array(
            'text' => '
                {
                    "xyz": "abc"
                }
            ',
            'regex' => '/"xyz": *"(?P<XyZ>[^"]+)"/'
        );
        $this->setParams($params);
        $this->exec()->shouldReturn(array('XyZ' => 'abc'));
    }

    function it_should_parse_using_params_in_verbose_mode()
    {
        $params = array(
            'text'  => '  "url"  :  "http://example.net" ',
            'regex' => '/"url" *: *"(?P<url>[^"]+)"/'
        );
        $this->setParams($params);
        $this->setVerbose(true);
        $this->exec()->shouldReturn('ParseVariable["url"=>"http://example.net"]');
    }

}
