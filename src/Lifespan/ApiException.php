<?php

namespace Minhyung\Fss\Lifespan;

use RuntimeException;
use Throwable;

class ApiException extends RuntimeException
{
    protected string $responseCode = '';

    /**
     * 예외 생성자
     * 
     * @param  string          $responseCode
     * @param  string          $message
     * @param  int             $code
     * @param  \Throwable|null $previous
     * @return void
     */
    public function __construct(string $responseCode, string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->responseCode = $responseCode;
    }

    /**
     * 응답코드 반환
     * 
     * @return string
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }
}
