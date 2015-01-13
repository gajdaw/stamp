<?php

namespace Stamp\Action;
use Stamp\Action\FileReader;
use Stamp\Action\ParseVariable;

class ParseVariableFromFile
{
    private $filename;
    private $regex;
    private $fileReader;
    private $result;
    private $output;
    private $verbose = false;

    public function __construct(FileReader $fileReader, ParseVariable $variableParser)
    {
        $this->fileReader = $fileReader;
        $this->variableParser = $variableParser;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function setRegex($regex)
    {
        $this->regex = $regex;
    }

    public function setParams($array)
    {
        $this->setFilename($array['filename']);
        $this->setRegex($array['regex']);
    }

    public function exec()
    {
        $contents = $this->fileReader->fileGetContents($this->filename);
        $this->variableParser->setParams(array(
            'text' => $contents,
            'regex' => $this->regex
        ));

        $resultToBeReturned = $this->variableParser->exec();
        if (!$resultToBeReturned) {
            $this->output = sprintf(
                'parse_variable_from_file["filename"="%s"]',
                $this->filename
            );

            return false;
        }

        $this->result = $this->variableParser->getResult();

        if ($this->verbose) {
            $key = array_keys($this->result)[0];
            $this->output = sprintf(
                'parse_variable_from_file["filename"="%s"]["%s"="%s"]',
                $this->filename,
                $key, $this->result[$key]
            );
        }

        return $resultToBeReturned;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setVerbose($verbose)
    {
        $this->verbose = $verbose;
    }
}
