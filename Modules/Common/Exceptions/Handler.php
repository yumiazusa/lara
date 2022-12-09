<?php

namespace Modules\Common\Exceptions;

use Doctrine\Common\Cache\Psr6\InvalidArgument;
use Doctrine\DBAL\Query\QueryException;
use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Throwable;
use Modules\Common\Exceptions\ApiException;
use ParseError;
use ReflectionException;
use RuntimeException;

class Handler extends ExceptionHandler
{
    private $status = 0;
    private $massage ='';
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

    /**
     * @description: 定义异常状态
     * @param {*}
     * @return {*}
     */    
    private function setErrorException($e){
        if($e instanceof ParseError){
            $this->status = StatusData::PARES_ERROR;
            $this->message = MessageData::PARES_ERROR;
        }
        if($e instanceof \ReflectionException){
            $this->status = StatusData::REFLECTION_EXCEPTION;
            $this->message = MessageData::REFLECTION_EXCEPTION;
        }
        if($e instanceof \RuntimeException){
            $this->status = StatusData::RUNTIME_EXCEPTION;
            $this->message = MessageData::RUNTIME_EXCEPTION;
        }
        if($e instanceof \ErrorException){
            $this->status = StatusData::ERROR_EXCEPTION;
            $this->message = MessageData::ERROR_EXCEPTION;
        }
        if($e instanceof \InvalidArgumentException){
            $this->status = StatusData::INVALID_ARGUMENT_EXCEPTION;
            $this->message = MessageData::INVALID_ARGUMENT_EXCEPTION;
        }
        if($e instanceof ModelNotFoundException){
            $this->status = StatusData::MODEL_NOT_FOUND_EXCEPTION;
            $this->message = MessageData::MODEL_NOT_FOUND_EXCEPTION;
        }
        if($e instanceof QueryException){
            $this->status = StatusData::QUERY_EXCEPTION;
            $this->message = MessageData::QUERY_EXCEPTION;
        }
    }

    public function render($request, Throwable $e)
    {
        if($request->is("api/*")){
            $this->setErrorException($e);
            if($this->status){
               if($this->status == 60001){
                    $data['message']= $e->getModel();
               }else{
                    $data['message']= $e->getMessage();
               }
                $data = [
                    "file"=>$e->getFile(),
                    "line"=>$e->getLine()
                ];
                return response()->json([
                    'status' => $this->status,
                    'message'=> env(key:"APP_DEBUG")? $this->message:MessageData::COMMON_EXCEPTION,
                    'data'=>$data
                ],status:CodeData::INTERNAL_SERVER_ERROR);
            }
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
