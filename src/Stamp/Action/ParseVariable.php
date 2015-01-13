<?php

namespace Stamp\Action;

class ParseVariable
{
    private $text = '';
    private $regex = '';
    private $result;
    private $output;
    private $verbose = false;

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setRegex($regex)
    {
        $this->regex = $regex;
    }

    public function exec()
    {
        try {
            $resultOfMatching = preg_match($this->regex, $this->text, $matches);
        } catch (\PhpSpec\Exception\Example\ErrorException $e) {
            throw new \RuntimeException(sprintf('Error during parsing regex [[%s]]', $this->regex));
        }

        if ($resultOfMatching) {
            unset($matches[0]);
            unset($matches[1]);

            if ($this->verbose) {
                $key = array_keys($matches)[0];
                $this->output = sprintf('ParseVariable["%s"=>"%s"]', $key, $matches[$key]);
            }

            $this->result = $matches;

            return true;
        }
        return false;
    }

    public function setParams($array)
    {
        $this->setText($array['text']);
        $this->setRegex($array['regex']);
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setVerbose($verbose)
    {
        $this->verbose = $verbose;
    }
}
