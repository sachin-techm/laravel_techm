<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

        // This method will render the exception faced on server side which will restrict the user to view whoops screen of laravel exception.
        
        $this->renderable(function (\Throwable $e, $request) {
            if($request->is('api/*')){
                
                $code   =   $e->getCode();
                $msg    =   'Server error, Please try again later';
                
                if ($this->isHttpException($e)) {

                    $code = $e->getStatusCode() ?? '';
                    if($code == 429){
                        $msg = "Dear Member, We are still processing your previous requests.  Please allow a little bit of time for those to process and try again.  Thank You!";
                    }
                }

                if(strpos( $e->getMessage() , 'Unauthenticated') !== false){
                    $code = '401';
                }
 
                return response(
                    [
                        'status'                =>  false,
                        'message'               =>  $msg,
                        'data'                  =>  null,
                        'developer_message'     =>  $e->getMessage(),
                        'file'                  =>  $e->getFile(),
                        'line'                  =>  $e->getLine(),
                        'code'                  =>  $code,
                    ]
                );
                
            } else { 

                // return $this->returnErrorView($e, $request);
            }
        });
              
    }

    // This method will return the error rather than Whooops screen of the laravel
    public function returnErrorView($e, $request){
        
        if ($request->is('admin') || $request->is('admin/*')) {
                
            $error = [
                'status'                =>  false,
                'message'               =>  'Server error, Please try again later',
                'data'                  =>  null,
                'developer_message'     =>  $e->getMessage(),
                'file'                  =>  $e->getFile(),
                'line'                  =>  $e->getLine(),
                'code'                  =>  $e->getCode(),
            ];
            
            return response()->view('errors.admin.system')->with('error', $error );
        }

        return response()->view('errors.system', [], 404);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {

        if ($request->is('admin') || $request->is('admin/*')) {

            return redirect()->guest(route('admin.login'));
        }

        // We don't need frontend
        return abort(404);
        return redirect()->guest(route('login'));
    }
}
