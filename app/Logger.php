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
    public function format($level, $message, array $context): ?string
    {
        $data = '[' . $this->getDate() . ']' . '[' . $level . ']' . '[' . $message . ']';
        $data .= json_encode($context);
        return $data;
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
        $data = $this->format($level, $message, $context);
        $this->write($data);
    }

    public function write($data)
    {
        file_put_contents($this->pathToFile, $data, FILE_APPEND);
    }
}
