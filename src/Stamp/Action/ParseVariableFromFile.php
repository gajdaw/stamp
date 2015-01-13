<?php

namespace Stamp\Action;

use Stamp\Tools\FileReader;
use Stamp\Tools\VariableContainer;

class ParseVariableFromFile
{
    private $filename;
    private $regex;
    private $fileReader;
    private $variableParser;
    private $variableContainer;
    private $result;
    private $output;
    private $verbose = false;
    private $dryRun = false;

    public function __construct(
        FileReader $fileReader,
        ParseVariable $variableParser,
        VariableContainer $variableContainer
    ) {
        $this->fileReader = $fileReader;
        $this->variableParser = $variableParser;
        $this->variableContainer = $variableContainer;
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
        $key = array_keys($this->result)[0];

        if ($this->verbose) {
            $this->output = sprintf(
                'parse_variable_from_file["filename"="%s"]["%s"="%s"]',
                $this->filename,
                $key, $this->result[$key]
            );
        }

        $this->variableContainer->setVariable($key, $this->result[$key]);

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

    public function setDryRun($dryRun)
    {
        $this->dryRun = $dryRun;
    }
}
