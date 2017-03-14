<?php
namespace Communication\Utilities;


class Utility
{
    public function spaceLess($string)
    {
        return trim($string);
    }

    public function toJson($data)
    {
        return json_encode($data);
    }

    public function toBase64($data)
    {
        return base64_encode($data);
    }
}
