<?php

namespace Minhyung\Fss\FinLife;

use RuntimeException;
use Throwable;

class ApiException extends RuntimeException
{
    protected string $errorCode = '';

    /**
     * 예외 생성자
     * 
     * @param  string          $errorCode
     * @param  string          $message
     * @param  int             $code
     * @param  \Throwable|null $previous
     * @return void
     */
    public function __construct(string $errorCode, string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->errorCode = $errorCode;
    }

    /**
     * 응답코드 반환
     * 
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}
