<?php
/**
 * Created for Crewkie on 3/21/15.
 *
 * @author Robbie Vaughn
 */
namespace CrewkieApi\Http\Controllers;

use CrewkieApi\Model\GameAccount;

/**
 * Contains miscellaneous actions
 *
 * @package     CrewkieApi\Http\Controllers
 */
class GameAccountController extends Controller
{
    public function anyFind()
    {
        $whereBind              = [];

        // Instantiate $gameAccount.
        $gameAccount            = new GameAccount;

        // Get request params.
        $accountId              = $this->request->get('accountId', null);
        $username               = $this->request->get('username', null);
        $password               = $this->request->get('password', null);

        // Using request params, set-up the $whereBind.
        if (!empty($accountId)) {
            $whereBind['account_id']    = $accountId;
        }

        if (!empty($username)) {
            $whereBind['userid']        = $username;
        }

        if (!empty($password)) {
            $whereBind['user_pass']     = $password;
        }

        // Pull data from the model.
        $data                   = $gameAccount::where($whereBind)->first();

        if (!empty($data)) {
            $data               = $data->toArray();
        }

        return $this->apiResponse->output($data);
    }

    public function anyEncryptpassword()
    {
        // TODO: Improve encryption. Project for another day. :P
        return $this->apiResponse->output(MD5($this->request->get('password', '')));
    }
}