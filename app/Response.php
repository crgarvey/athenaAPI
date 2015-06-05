<?php
/**
 * Created for Crewkie on 3/21/15.
 *
 * @author Robbie Vaughn
 */

/**
 * Handles responses for the CrewkieApi
 */
namespace CrewkieApi;

class Response
{
    const MIN_CUSTOM_ERROR_CODE = 2000;
    const ERROR_CODE_SUCCESS = 200;
    const ERROR_CODE_BADREQUEST = 400;
    const ERROR_CODE_INTERNALERROR = 500;
    const DESCRIPTION_SUCCESS = 'Success';
    const DESCRIPTION_ERROR = 'Error';
    const ENCODING_JSON = 'json';
    const ENCODING_HTTP = 'http';
    const ENCODING_DEFAULT = self::ENCODING_JSON;
    public static $encodingList = [
        'json',
        'http'
    ];

    /**
     * Build & return a response based on Encoding.
     *
     * @param       []|null         $data
     * @param       string          $description
     * @param       integer         $responseCode
     * @param       string          $encoding
     * @return      string|\Symfony\Component\HttpFoundation\Response
     */
    public function output(
        $data = null,
        $description = self::DESCRIPTION_SUCCESS,
        $responseCode = self::ERROR_CODE_SUCCESS,
        $encoding = self::ENCODING_DEFAULT
    ) {
        // Build output array
        $outputArray        = [
            'responseCode'  => $responseCode,
            'description'   => $description,
            'data'          => $data,
            'encoding'      => $encoding
        ];

        $response           = '';

        // Switch...
        switch ($encoding)
        {
            default:
            case static::ENCODING_JSON:
                $response   = response()->json($outputArray, $responseCode);
                break;
            case static::ENCODING_HTTP:
                $response   = response()->make(http_build_query($outputArray), $responseCode);
                break;
        }

        return $response;
    }
}