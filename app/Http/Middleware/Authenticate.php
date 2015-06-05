<?php namespace CrewkieApi\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use CrewkieApi\Model\User;
use CrewkieApi\Model\UserIp;
use CrewkieApi\Response as ApiResponse;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth, ApiResponse $apiResponse)
	{
		$this->auth = $auth;
        $this->apiResponse = $apiResponse;
	}

	/**
     * Simply put, this method handles simple authentication and the inbound request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
    {
        // Get apiuser and apikey from the sent request
        $apiUserId      = $request->get('apiUser', null);
        $apiKey         = $request->get('apiKey', null);
        $ipAddress      = $request->getClientIp();

        // Instantiate userObj
        $userObj        = new User;

        /**
         * First check if a record exists by the user ID and key provided
         *
         * @var     $apiUserRecord      User
         */
        $apiUserRecord  = $userObj->find($apiUserId);

        if (!empty($apiUserRecord) && ($apiUserRecord instanceof User) === true) {
            $key        = $apiUserRecord->getKey();

            // Do the keys equal each other?
            if ($apiKey == $key) {
                // Now, validate by IP.
                $userIp = $apiUserRecord->ipList()->where('ip', '=', $ipAddress)->first();

                // Check if found record and instanceof UserIp model
                if (!empty($userIp) && ($userIp instanceof UserIp) === true) {
                    // Update latestauth_at timestamp
                    $apiUserRecord->latestauth_at       = new \DateTime;
                    $apiUserRecord->save();

                    // Technically, this is considered authenticated..
                    session(['user' => $apiUserRecord]);
                    return $next($request);
                }

            }
        }

        // Not authenticated. Abort with a 404.
        $response       = $this->apiResponse;
        $this->apiResponse->output(null, $response::DESCRIPTION_ERROR);
	}

}
