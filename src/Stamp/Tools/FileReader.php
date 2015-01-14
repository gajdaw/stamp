<?php

namespace Stamp\Tools;

class FileReader
{

    public function fileGetContents($file)
    {
        return file_get_contents($file);
    }

    public function filePutContents($file, $contents)
    {
        return file_put_contents($file, $contents);
    }
}
