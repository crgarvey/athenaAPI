<?php namespace CrewkieApi\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use CrewkieApi\Response;
use CrewkieApi\Model\User;
use Illuminate\Support\Facades\Session;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
        // Set default encoding.
        $encoding       = Response::ENCODING_DEFAULT;

        /**
         * If user data exists, grab encoding.
         *
         * @var     User        $apiUserRecord
         */
        $apiUserRecord  = session('user', null);

        if (!empty($apiUserRecord)) {
            $encoding   = $apiUserRecord->getEncoding();
        }

        if ($e->getCode() >= Response::MIN_CUSTOM_ERROR_CODE) {
            return (new Response)->output(null, $e->getMessage(), $e->getCode(), $encoding);
        }

        return (new Response)->output(
            null,
            Response::DESCRIPTION_ERROR,
            Response::ERROR_CODE_INTERNALERROR,
            $encoding
        );
	}

}
