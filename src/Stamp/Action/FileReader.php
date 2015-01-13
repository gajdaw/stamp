<?php

namespace Stamp\Action;

class FileReader
{

    public function fileGetContents($file)
    {
        return file_get_contents($file);
    }
}
