<?php

namespace Stamp\Action;

class ParseVariableAction extends BaseAction implements ActionInterface
{
    private $text = '';
    private $regex = '';

    public function getActionName()
    {
        return 'parse_variable';
    }

    public function setParams($array)
    {
        $this->setText($array['text']);
        $this->setRegex($array['regex']);
    }

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
                $this->setOutput(sprintf('parse_variable["%s"=>"%s"]', $key, $matches[$key]));
            }

            $this->setResult($matches);

            return true;
        }
        return false;
    }

}
