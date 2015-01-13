<?php

namespace spec\Stamp\Tools;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileReaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Stamp\Tools\FileReader');
    }

    function it_should_read_a_file()
    {
        $file = __FILE__;
        $contents = file_get_contents($file);
        $this->fileGetContents($file)->shouldReturn($contents);
    }

}
