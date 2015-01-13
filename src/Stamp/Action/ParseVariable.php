<?php

namespace Stamp\Action;

class ParseVariable
{
    private $text = '';
    private $regex = '';
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
        if (preg_match($this->regex, $this->text, $matches)) {
            unset($matches[0]);
            unset($matches[1]);
            if ($this->verbose) {
                $key = array_keys($matches)[0];
                return sprintf('ParseVariable["%s"=>"%s"]', $key, $matches[$key]);
            }
            return $matches;
        }
        return false;
    }

    public function setParams($array)
    {
        $this->setText($array['text']);
        $this->setRegex($array['regex']);
    }

    public function setVerbose($verbose)
    {
        $this->verbose = $verbose;
    }
}
