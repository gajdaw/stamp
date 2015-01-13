<?php

namespace Stamp\Tools;

class FileReader
{

    public function fileGetContents($file)
    {
        return file_get_contents($file);
    }
}
