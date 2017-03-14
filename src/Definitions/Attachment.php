<?php

namespace Communication\Definitions;

use Communication\Utilities\File;
use Communication\Utilities\Utility;

class Attachment
{
    public $data;

    public $name;

    /**
     * @param $filePath
     * @param $attachmentName
     * @throws \Communication\Exceptions\FileSystem
     */
    public function __construct($filePath, $attachmentName)
    {
        $this->name = $attachmentName;

        $fileData = (new File)->readFile($filePath);

        $this->data = (new Utility)->toBase64($fileData);
    }
}
