<?php

namespace Modules\Common\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;
use Modules\Common\Exceptions\ApiException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if($request->is("api/*")){
            if($e instanceof ApiException){
                $result =[
                    'status' => $e->getCode(),
                    'message'=> $e->getMessage(),
                ];
                return response()->json($result,status:CodeData::INTERNAL_SERVER_ERROR);
            }else if($e instanceof ValidationException){
                $result =[
                    'status'=>StatusData::BAD_REQUEST,
                    'message'=>array_values($e->errors())[0][0]
                ];
                return response()->json($result,status:CodeData::BAD_REQUEST);
            }
        }
        return parent::render($request,$e);
    }
}
