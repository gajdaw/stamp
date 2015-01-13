<?php

namespace spec\Stamp\Action;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Stamp\Tools\FileReader;
use Stamp\Action\ParseVariable;
use Stamp\Tools\VariableContainer;

class ParseVariableFromFileSpec extends ObjectBehavior
{

    function let(
        FileReader $fileReader,
        ParseVariable $variableParser,
        VariableContainer $variableContainer
    ) {
        $this->beConstructedWith(
            $fileReader,
            $variableParser,
            $variableContainer
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Stamp\Action\ParseVariableFromFile');
    }

    function it_should_parse_a_variable_from_file_in_dry_run_mode(FileReader $fileReader, ParseVariable $variableParser)
    {
        $text = '
            "name"  :   "Lorem"
        ';
        $params = array(
            'filename' => 'fake.file.json',
            'regex' => '/"name" *: *"(?P<name>[^"]+)"/'
        );

        $fileReader->fileGetContents($params['filename'])->willReturn($text);
        $variableParser->exec()->willReturn(true);
        $variableParser->getResult()->willReturn(array('name'=>'Lorem'));

        $this->setParams($params);
        $variableParser->setParams(array(
            'text' => $text,
            'regex' => $params['regex']
        ))->shouldBeCalled();
        $variableParser->getResult()->shouldBeCalled();

        $this->exec()->shouldReturn(true);
        $this->getResult()->shouldReturn(array('name' => 'Lorem'));
        $this->getOutput()->shouldReturn(null);
    }

    function it_should_parse_a_variable_from_file_in_verbose_mode(
        FileReader $fileReader, ParseVariable $variableParser,
        VariableContainer $variableContainer
    ) {
        $text = '
            "name"  :   "Lorem"
        ';
        $params = array(
            'filename' => 'f.json',
            'regex' => '/"name" *: *"(?P<name>[^"]+)"/'
        );

        $fileReader->fileGetContents($params['filename'])->willReturn($text);

        $variableParser->exec()->willReturn(true);
        $variableParser->getResult()->willReturn(array('name'=>'Lorem'));
        $variableParser->setParams(array(
            'text' => $text,
            'regex' => $params['regex']
        ))->shouldBeCalled();
        $variableParser->getResult()->shouldBeCalled();
        $variableContainer->setVariable('name', 'Lorem')->shouldBeCalled();

        $this->setParams($params);
        $this->setVerbose(true);
        $this->exec()->shouldReturn(true);
        $this->getResult()->shouldReturn(array('name' => 'Lorem'));
        $this->getOutput()->shouldReturn('parse_variable_from_file["filename"="f.json"]["name"="Lorem"]');
    }

    function it_should_fail_when_variable_is_not_present(FileReader $fileReader, ParseVariable $variableParser)
    {
        $text = '...the text does not contain this variable...';
        $params = array(
            'filename' => 'f.json',
            'regex' => '/"name" *: *"(?P<name>[^"]+)"/'
        );

        $fileReader->fileGetContents($params['filename'])->willReturn($text);

        $variableParser->exec()->willReturn(false);
        $variableParser->setParams(array(
            'text' => $text,
            'regex' => $params['regex']
        ))->shouldBeCalled();


        $this->setParams($params);
        $this->setVerbose(true);
        $this->exec()->shouldReturn(false);
        $this->getResult()->shouldReturn(null);
        $this->getOutput()->shouldReturn('parse_variable_from_file["filename"="f.json"]');
    }
}
