<?php

namespace App;

use DateTime;
use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;


class LoggerNew extends AbstractLogger
{
    public string $pathToFile;

    private Formater $formater;

    private Writer $writer;

    public function __construct(string $pathToFile)
    {
        $this->pathToFile = $pathToFile;
        if (!file_exists($this->pathToFile)) {
            touch($this->pathToFile);
        }

        $this->formater = new Formater();

        $this->writer = new Writer($this->pathToFile);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     * @throws InvalidArgumentException
     */
    public function log($level, $message, array $context = array())
    {
        $data = $this->formater->format($level, $message, $context);
        $this->writer->write($data);
    }
}