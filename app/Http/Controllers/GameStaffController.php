<?php
/**
 * Created for Crewkie on 3/21/15.
 *
 * @author Robbie Vaughn
 */
namespace CrewkieApi\Http\Controllers;
use CrewkieApi\Model\Game\Timeclock;

/**
 * Contains actions related to Game Staff.
 *
 * @package     CrewkieApi\Http\Controllers
 */
class GameStaffController extends Controller
{
    public function anyTimeclockfindallby()
    {
        // TODO: Add support for staffName (character name) -> account ID and character ID
        $staffName      = $this->request->get('staffName', null);
        $startDate      = $this->request->get('startDate', null);
        $endDate        = $this->request->get('endDate', null);

        return $this->apiResponse->output((new Timeclock($this->cache))->findAllBy(
            $staffName,
            $startDate,
            $endDate
        ));
    }
}