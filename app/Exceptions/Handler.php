<?php

namespace App\Exceptions;

use Exception;
use \Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;

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
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     * @return mixed
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if($request->expectsJson())
        {
            return response()->json(['error'=>'Unathenticated'], 401);
        }
        //$guard = array_get($exception->guards(),0); //deprecated in laravel 6
        $guard = Arr::get($exception->guards(), 0);
        switch($guard)
        {
            case 'student':
                $login = 'student.login';
            break;
            case 'dean':
                $login = 'dean.login';
            break;
            case 'cod':
                $login = 'cod.login';
            break;
            case 'registrar':
                $login = 'registrar.login';
            break;
            default:
            $login = 'login';
        break;
        }
        return redirect()->guest(route($login));
    }
}
