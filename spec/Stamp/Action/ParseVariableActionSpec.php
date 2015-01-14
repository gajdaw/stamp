<?php

namespace spec\Stamp\Action;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParseVariableActionSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('Stamp\Action\ParseVariableAction');
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
        $this->exec()->shouldReturn(true);
        $this->getResult()->shouldReturn(array('NAME' => '1.2.3.4'));
        $this->getOutput()->shouldReturn(null);
    }

    function it_should_fail_when_var_is_not_found()
    {
        $params = array(
            'text' => '...lorem ipsum...',
            'regex' => '/"xyz": *"(?P<XyZ>[^"]+)"/'
        );
        $this->setParams($params);
        $this->exec()->shouldReturn(false);
        $this->getResult()->shouldReturn(null);
        $this->getOutput()->shouldReturn(null);
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
        $this->exec()->shouldReturn(true);
        $this->getResult()->shouldReturn(array('XyZ' => 'abc'));
        $this->getOutput()->shouldReturn(null);
    }

    function it_should_parse_using_params_in_verbose_mode()
    {
        $params = array(
            'text'  => '  "url"  :  "http://example.net" ',
            'regex' => '/"url" *: *"(?P<url>[^"]+)"/'
        );
        $this->setParams($params);
        $this->setVerbose(true);
        $this->exec()->shouldReturn(true);
        $this->getResult()->shouldReturn(array('url' => 'http://example.net'));
        $this->getOutput()->shouldReturn('parse_variable["url"=>"http://example.net"]');
    }

    function it_should_throw_an_exception_for_incorrect_regex()
    {
        $params = array(
            'text'  => '  "url"  :  "http://example.net" ',
            'regex' => '/"url" *: *"(?P<url>[^"]+"/'
        );
        $this->setParams($params);
        $this->shouldThrow(new \RuntimeException(sprintf(
            'Error during parsing regex [[%s]]',
            $params['regex']
        )))->duringExec();
    }

    function it_should_throw_an_exception_for_regex_without_named_subpatterns()
    {
        $params = array(
            'text'  => '  "url"  :  "http://example.net" ',
            'regex' => '/url/'
        );
        $this->setParams($params);
        $this->shouldThrow(new \RuntimeException(sprintf(
            'Regex "%s" does not contain any named subpatterns!',
            $params['regex']
        )))->duringExec();
    }

}
