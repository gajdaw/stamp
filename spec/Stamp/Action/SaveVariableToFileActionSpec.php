<?php

namespace spec\Stamp\Action;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Stamp\Tools\FileReader;
use Stamp\Tools\VariableContainer;


class SaveVariableToFileActionSpec extends ObjectBehavior
{
    function let(
        VariableContainer $variableContainer,
        FileReader $fileReader
    ) {
        $this->beConstructedWith(
            $variableContainer,
            $fileReader
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Stamp\Action\SaveVariableToFileAction');
    }

    function it_should_save_a_variable_to_file_in_dry_run_mode(VariableContainer $variableContainer, FileReader $fileReader)
    {
        $text = ' "name": "John Doe" ';
        $params = array(
            'filename' => 'fake.file.json',
            'variable' => 'person',
            'src'      => '/"name" *: *"[^"]+"/',
            'dest'     => '"name": "{{ person }}"'
        );

        $fileReader->fileGetContents($params['filename'])->willReturn($text);
//        $variableContainer->getVariable('person')->willReturn('Lorem Ipsum');
        $variableContainer->getVariables()->willReturn(array(
            'person' => 'Lorem Ipsum'
        ));
        $fileReader->filePutContents($params['filename'], ' "name": "Lorem Ipsum" ')->shouldBeCalled();

        $this->setParams($params);
        $this->setVerbose(true);

        $this->exec()->shouldReturn(true);
        $this->getOutput()->shouldReturn('save_variable_to_file["name": "Lorem Ipsum"]');
    }

}
