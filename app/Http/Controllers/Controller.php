<?php namespace CrewkieApi\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use CrewkieApi\Response as ApiResponse;
use Illuminate\Cache\Repository as Cache;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

    /**
     * @var     ApiResponse
     */
    protected $apiResponse;

    public function __construct(Response $response, ApiResponse $apiResponse, Request $request, Cache $cache)
    {
        $this->request      = $request;
        $this->response     = $response;
        $this->apiResponse  = $apiResponse;
        $this->cache        = $cache;
    }
}
