<?php

namespace App;

class Writer implements WriterInterface
{
    public string $pathToFile;
    public string $data;

    public function __construct($pathToFile)
    {
        $this->pathToFile = $pathToFile;
    }

    public function write($data)
    {
        file_put_contents($this->pathToFile, $data, FILE_APPEND);
    }
}
