<?php

namespace Stamp\Action;

use Stamp\Tools\FileReader;
use Stamp\Tools\VariableContainer;
use Twig_Loader_Array;
use Twig_Environment;

class SaveVariableToFileAction extends BaseAction implements ActionInterface
{
    private $filename;
    private $variable;
    private $src;
    private $dest;

    private $variableContainer;
    private $fileReader;

    public function __construct(
        VariableContainer $variableContainer,
        FileReader $fileReader
    ) {
        $this->variableContainer = $variableContainer;
        $this->fileReader = $fileReader;
    }

    public function getActionName()
    {
        return 'save_variable_to_file';
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function setVariable($variable)
    {
        $this->variable = $variable;
    }

    public function setSrc($src)
    {
        $this->src = $src;
    }

    public function setDest($dest)
    {
        $this->dest = $dest;
    }

    public function setParams($array)
    {
        $this->setFilename($array['filename']);
        $this->setVariable($array['variable']);
        $this->setSrc($array['src']);
        $this->setDest($array['dest']);
    }

    public function exec()
    {
        $contents = $this->fileReader->fileGetContents($this->filename);

        $loader = new Twig_Loader_Array(array(
            'template' => $this->dest,
        ));
        $twig = new Twig_Environment($loader);
        $renderedDest = $twig->render('template', $this->variableContainer->getVariables());

        $newContents = preg_replace($this->src, $renderedDest, $contents);

        if ($this->verbose) {
            $this->setOutput(sprintf('save_variable_to_file[%s]', $renderedDest));
        }

        if (!$this->dryRun) {
            $this->fileReader->filePutContents($this->filename, $newContents);
        }

        return true;
    }

}
