<?php

namespace Stamp\Action;

class ParseVariable
{
    private $text = '';
    private $regex = '';

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setRegex($regex)
    {
        $this->regex = $regex;
    }

    public function getParsed()
    {
        if (preg_match($this->regex, $this->text, $matches)) {
            unset($matches[0]);
            unset($matches[1]);
            return $matches;
        }
        return false;
    }
}
