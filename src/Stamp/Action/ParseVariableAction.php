<?php

namespace Stamp\Action;

use RuntimeException;

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
        } catch (\Exception $e) {
            throw new RuntimeException(sprintf('Error during parsing regex [[%s]]', $this->regex));
        }

        if (!$resultOfMatching) {
            throw new RuntimeException(sprintf(
                'Regex "%s" does not match!',
                $this->regex
            ));
        }

        if (count($matches) < 3) {
            throw new RuntimeException(sprintf(
                'Regex "%s" does not contain any named subpatterns!',
                $this->regex
            ));
        }

        if (count($matches) > 3) {
            throw new RuntimeException(sprintf(
                'Regex "%s" - to many subpatterns!',
                $this->regex
            ));
        }

        unset($matches[0]);
        unset($matches[1]);

        if ($this->verbose) {
            $key = array_keys($matches)[0];
            $this->setOutput(sprintf('parse_variable["%s"=>"%s"]', $key, $matches[$key]));
        }

        $this->setResult($matches);

        return true;
    }

}
