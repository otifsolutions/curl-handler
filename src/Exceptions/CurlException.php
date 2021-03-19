<?php

namespace OTIFSolutions\CurlHandler;
namespace OTIFSolutions\CurlHandler\Exceptions;

use Throwable;

class CurlException extends \Exception{
    private $curlErrors;

    /**
     * CurlException constructor.
     * @param array $curlErrors
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($curlErrors =[], $message = "", $code = 0, Throwable $previous = null)
    {
        $this->curlErrors = $curlErrors;
        parent::__construct($message, $code, $previous);
    }
    /**
     * @return array
     */
    public function getCurlErrors():array{
        return $this->curlErrors;
    }

}
