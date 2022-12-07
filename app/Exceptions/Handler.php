<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\User;
use Mail;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use App\Mail\ExceptionOccured;
use Auth;
use Request;
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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        // if ($this->shouldReport($exception)) {
        //                             $e = FlattenException::create($exception);
        //                             $handler = new SymfonyExceptionHandler();
        //                             $content = $handler->getHtml($e);
        //                            //$toEmails = Subscribers::report_subscribers('errors_report');
        //                            $toEmails = array();
        //                            $toEmails[] = 'usama@helfertech.net';
        //                            $toEmails[] = 'azam@helfertech.com';
        //                            if(!strpos($content, 'was only partially uploaded')){
        //                                    Mail::send('emails.notification_error_report', ['content' => $content, 'url' => Request::url()], function ($m) use ($toEmails){
        //                                         $m->from('intelidus360@gmail.com', 'Intelidus');
        //                                         $m->to($toEmails)->subject('Intelidus Error Report');
        //                                    });
        //                                     }
        //                                 }
        // parent::report($exception);
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
        return parent::render($request, $exception);
    }
}
