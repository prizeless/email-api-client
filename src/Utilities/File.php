<?php
namespace Communication\Utilities;

use Communication\Exceptions\FileSystem;

class File
{
    public function readFile($filePath)
    {
        $resource = fopen(realpath($filePath), 'r');

        $text = @fread($resource, filesize($filePath));

        if ($text === false) {
            throw new FileSystem('read file' . $filePath);
        }

        return $text;
    }
}
