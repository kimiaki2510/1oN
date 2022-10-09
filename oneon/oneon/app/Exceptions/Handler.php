<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Render an exception into an HTTP response.
     * 特定のHTTPステータス以外はシステムエラー画面を表示するように拡張する
     * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $exception
     * @return string
     *
     */
    protected function getHttpExceptionView(HttpExceptionInterface $exception)
    {
        if (in_array($exception->getStatusCode(), ['403', '404', '422', '503'])) {
            return "errors::{$exception->getStatusCode()}";
        }
        return 'errors::500';
    }

}
