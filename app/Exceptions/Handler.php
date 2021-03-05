<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
// use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Component\Routing\Exception\RouteNotFoundException ;

use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        // \League\OAuth2\Server\Exception\OAuthServerException::class,
     
    
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
     */
    public function report(Exception $exception)
    {
        if ($exception instanceof OAuthServerException) {
            try {
                $logger = $this->container->make(LoggerInterface::class);
            } catch (Exception $e) {
                throw $exception; // throw the original exception
            }
    
            $logger->error(
                $exception->getMessage(),
                ['exception' => $exception]
            );
        } else {
            parent::report($exception);
        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $class = get_class($exception);
        if($request->expectsJson())
        {

        if($exception instanceof QueryException)
        {
            return response()->json(["msg" => "invalid crediantial", 'status'=>404,'data'=>" " ],Response::HTTP_NOT_FOUND);
        }

       
        if($exception instanceof OAuthServerException)
        {
            return response()->json(["msg" => "invalid token", 'status'=>404,'data'=>" " ],Response::HTTP_NOT_FOUND);
        }

       
    


    }
   

    return parent::render($request, $exception);
}

}
