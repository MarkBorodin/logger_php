<?php


namespace App;


use DateTime;
use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;

class Logger extends AbstractLogger implements LoggerInterface
{

    /**
     * @var string path to file
     */
    public string $pathToFile;
    /**
     * @var string massage template
     */
    public string $template = "{date} {level} {message} {context}";

    public function __construct(string $pathToFile)
    {
        $this->pathToFile = $pathToFile;
        if (!file_exists($this->pathToFile)) {
            touch($this->pathToFile);
        }
    }

    /**
     * @var string DateTime format
     */
    public string $dateFormat = DateTime::RFC2822;

    /**
     * Current date
     *
     * @return string
     */
    public function getDate(): string
    {
        return (new DateTime())->format($this->dateFormat);
    }

    /**
     * $context to string
     *
     * @param array $context
     * @return string
     */
    public function format(array $context = []): ?string
    {
        return !empty($context) ? json_encode($context) : null;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function log($level, $message, array $context = array())
    {
        $this->write($level, $message, $context);
    }

    public function write($level, $message, array $context = array())
    {
        file_put_contents($this->pathToFile, trim(strtr($this->template, [
                '{date}' => $this->getDate(),
                '{level}' => $level,
                '{message}' => $message,
                '{context}' => $this->format($context),
            ])) . PHP_EOL, FILE_APPEND);
    }
}
