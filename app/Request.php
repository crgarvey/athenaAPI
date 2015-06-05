<?php
/**
 * Created for Crewkie on 3/21/15.
 *
 * @author Robbie Vaughn
 */
namespace CrewkieApi;

/**
 * The CrewkieApi Request class deals with providing the ability to send requests to the API using cURL.
 * TODO: Add support for file_get_contents
 *
 * @package CrewkieApi
 */
class Request
{
    const ENGINE_CURL    = 'curl';
    const ENGINE_FILE    = 'file';
    const DEFAULT_ENGINE = self::ENGINE_CURL;

    /**
     * @var     string
     */
    private $apiUrl;

    /**
     * @var     string
     */
    private $apiUserId;

    /**
     * @var     string
     */
    private $apiKey;

    public function __construct($apiUrl, $apiUserId, $apiKey)
    {
        $this->apiUrl       = $apiUrl;
        $this->apiUserId    = $apiUserId;
        $this->apiKey       = $apiKey;
    }

    /**
     * Call overloader which is invoked when a method is called.
     *
     * Think of this as a bootstrap for the Request class. From here, we send off the API call through send.
     * Afterwards, we parse & return.
     *
     * @param       string      $name
     * @param       []          $argumentList
     * @return      mixed
     */
    public function __call($name, $argumentList)
    {
        // Instantiate a ReflectionMethod of the called method.
        $method             = new \ReflectionMethod(__CLASS__, $name);
        $parameterList      = $method->getParameters();
        $parameterPairList  = [];
        $count              = 0;

        // For each parameter, set accordingly.
        foreach ($parameterList as $parameter) {
            $parameterPairList[$parameter->getName()]   = (!empty($argumentList[$count])
                ? $argumentList[$count] : $parameter->getDefaultValue()
            );
            $count++;
        }

        // Send!
        return $this->send($name, $parameterPairList);
    }

    /**
     * This method is in charge of sending the request and returning data.
     *
     * @param       string      $apiMethod
     * @param       []          $data
     * @param       string      $engine
     * @return      mixed
     */
    public function send(
        $apiMethod,
        $data,
        $engine = self::DEFAULT_ENGINE
    ) {
        // Initialize blank apiUrl.
        $apiUrl         = $this->apiUrl;

        $apiMethod      =
            (method_exists($this, $apiMethod)
                ? (empty($this->$apiMethod())
                    ? $apiMethod : $this->$apiMethod())
                : $apiMethod
            );

        // Build data to send.
        $sendData       = [
            'apiUser'   => $this->apiUserId,
            'apiKey'    => $this->apiKey,
        ];

        // Append $apiMethod.
        $apiUrl         .= '/' . $apiMethod;

        // Add XDEBUG key.
        if (getenv('APPLICATION_ENV') == 'development') {
            $apiUrl     .= '?XDEBUG_SESSION_START=GGAPI&XDEBUG_PROFILE=1';
        }

        // Merge with $data.
        $sendData       = array_merge($data, $sendData);

        // Begin using cURL functions to send data (use POST to avoid GET limitations).
        $ch             = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendData));

        // Get the response.
        $response       = curl_exec($ch);

        $errorMsg       = '';

        // Log any error.
        if ($response === false) {
            $errorMsg   = 'CURL error:' . curl_error($ch);
        }

        // Close cURL.
        curl_close($ch);

        // Check if response is available.
        if (!empty($response)) {
            $result     = json_decode($response, true, 1024);

            if (isset($result['responseCode'])) {
                return $result;
            } else {
                return [
                    'responseCode'      => Response::ERROR_CODE_BADREQUEST,
                    'description'       => 'Invalid server response.'
                ];
            }
        }

        return [
            'responseCode'      => Response::ERROR_CODE_BADREQUEST,
            'description'       => 'No response from API server. ' . '(' . $errorMsg . ')'
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Faux methods for insight
    |--------------------------------------------------------------------------
    |
    | Below define methods, arguments, and such for apiMethods.
    | The __call method handles the magic of this class.
    |
    */

    private function ping() {}
    private function findGameAccount($accountId = null, $username = null, $password = null) { return 'game/account/find'; }
    private function encryptGameAccountPassword($password = null) { return 'game/account/encryptpassword'; }
    private function timeclockFindAllBy($staffName = null, $startDate = null, $endDate = null) { return 'game/staff/timeclockfindallby'; }
}