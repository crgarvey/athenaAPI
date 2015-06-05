<?php
/**
 * Created for Crewkie on 3/21/15.
 *
 * @author Robbie Vaughn
 */
namespace CrewkieApi\Http\Controllers;

/**
 * Contains miscellaneous actions
 *
 * @package     CrewkieApi\Http\Controllers
 */
class IndexController extends Controller
{
    public function anyPing()
    {
        return $this->apiResponse->output(true, 'Server pinged successfully!');
    }
}