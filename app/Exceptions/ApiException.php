<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class ApiException extends Exception
{
    // HTTP Errors 400 - 599
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_UNAUTHORIZED = 401;
    public const HTTP_FORBIDDEN = 403;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_METHOD_NOT_ALLOWED = 405;
    public const HTTP_CONFLICT = 409;
    public const HTTP_GONE = 410;
    public const HTTP_PRECONDITION_FAILED = 412;
    public const HTTP_SERVICE_UNAVAILABLE = 503;

    //custom errors 10000+
    public const OFFER_NOT_BELONG_USER = 10001;

    public const HTTP_SUCCESS = 200;

    private int $responseCode = self::HTTP_SUCCESS;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [

    ];

    /**
     * Report or log an exception.
     *
     * @return false
     */
    public function report(): bool
    {
        return false;
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            "success" => false,
            "error" => [
                'code' => $this->getCode(),
                'message' => __('errors.' . $this->getCode(), locale: Lang::getLocale()),
            ]
        ], $this->responseCode);
    }

    public static function generate(string $code): ApiException
    {
        $translatedMessage = __('errors.' . $code);
        return (new static($translatedMessage, $code))->setResponseCode(self::prependResponseCode($code));
    }

    public function setResponseCode(int $code): self
    {
        $this->responseCode = $code;

        return $this;
    }

    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    private static function prependResponseCode(int $code): int
    {
        if ($code >= 400 && $code < 600) {
            return $code;
        }

        if ($code > 10000) {
            return self::HTTP_BAD_REQUEST;
        }

        return self::HTTP_SUCCESS;
    }
}
