<?php

namespace spec\Stamp\Action;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Stamp\Tools\FileReader;
use Stamp\Action\ParseVariableAction;
use Stamp\Tools\VariableContainer;

class ParseVariableFromFileActionSpec extends ObjectBehavior
{

    function let(
        VariableContainer $variableContainer,
        FileReader $fileReader,
        ParseVariableAction $variableParser
    ) {
        $this->beConstructedWith(
            $variableContainer,
            $fileReader,
            $variableParser
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Stamp\Action\ParseVariableFromFileAction');
    }

    function it_should_parse_a_variable_from_file_in_dry_run_mode(FileReader $fileReader, ParseVariableAction $variableParser)
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
        FileReader $fileReader, ParseVariableAction $variableParser,
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

    function it_should_repeat_exception_from_variable_parser(FileReader $fileReader, ParseVariableAction $variableParser)
    {
        $text = '...the 123 text does not contain this variable...';
        $params = array(
            'filename' => 'f.json',
            'regex' => '/(?P<name>[\d]+)/'
        );

        $fileReader->fileGetContents($params['filename'])->willReturn($text);

        $variableParser->exec()->willThrow( new \RuntimeException(
            'Abc...'
        ));
        $variableParser->setParams(array(
            'text' => $text,
            'regex' => $params['regex']
        ))->shouldBeCalled();


        $this->setParams($params);
        $this->setVerbose(true);

        $this->shouldThrow(new \RuntimeException(sprintf(
            'Abc...'
        )))->duringExec();
    }

    function it_should_except_when_regex_doesnt_match_file(FileReader $fileReader, ParseVariableAction $variableParser)
    {
        $text = 'abc';
        $params = array(
            'filename' => 'f.json',
            'regex' => '/def/'
        );

        $fileReader->fileGetContents($params['filename'])->willReturn($text);

        $variableParser->exec()->willReturn(false);
        $variableParser->setParams(array(
            'text' => $text,
            'regex' => $params['regex']
        ))->shouldBeCalled();


        $this->setParams($params);
        $this->setVerbose(true);

        $this->shouldThrow(new \RuntimeException(sprintf(
            'Regex "%s" doesnt match anything in the file "%s"!',
            $params['regex'],
            $params['filename']
        )))->duringExec();
    }
}
