<?php

namespace Stamp\Action;

use Stamp\Tools\FileReader;
use Stamp\Tools\VariableContainer;
use Symfony\Component\Process\Exception\RuntimeException;

class ParseVariableFromFileAction extends BaseAction implements ActionInterface
{
    private $filename;
    private $regex;
    private $fileReader;
    private $variableParser;
    private $variableContainer;

    public function __construct(
        VariableContainer $variableContainer,
        FileReader $fileReader,
        ParseVariableAction $variableParser
    ) {
        $this->variableContainer = $variableContainer;
        $this->fileReader = $fileReader;
        $this->variableParser = $variableParser;
    }

    public function getActionName()
    {
        return 'parse_variable_from_file';
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

        try {
            $resultToBeReturned = $this->variableParser->exec();
        } catch (\RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Regex "%s" does not match anything in the file "%s"!',
                $this->regex,
                $this->filename
            ));
        }
        if (!$resultToBeReturned) {
            $this->setOutput(sprintf(
                'parse_variable_from_file["filename"="%s"]',
                $this->filename
            ));

            return false;
        }

        $this->setResult($this->variableParser->getResult());
        $key = array_keys($this->result)[0];

        if ($this->verbose) {
            $this->setOutput(sprintf(
                'parse_variable_from_file["filename"="%s"]["%s"="%s"]',
                $this->filename,
                $key, $this->result[$key]
            ));
        }

        $this->variableContainer->setVariable($key, $this->result[$key]);

        return $resultToBeReturned;
    }

}
