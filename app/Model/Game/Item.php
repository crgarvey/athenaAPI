<?php
/**
 * Created for Crewkie on 4/2/15.
 *
 * @author Robbie Vaughn
 */
namespace CrewkieApi\Model\Game;

use CrewkieApi\Model\Model;
use CrewkieApi\Model\GameItemDb;
use CrewkieApi\Model\GameItemDbCustom;
use DB;

class Item extends Model
{
    protected $connection   = GAME_CONNECTION_NAME;

    /**
     * Returns an instance of an item or false.
     *
     * @param       integer                                 $id
     * @return      GameItemDB|GameItemDbCustom|boolean
     */
    public function find($id)
    {
        $columnList     = ['id'];

        // Attempt to find within Custom first.
        $total          = $this->getConnection()
            ->table('item_db2')
            ->select($columnList)
            ->where(['id'    => $id])
            ->count()
            ;

        if (!empty($total)) {
            return true;
        }

        // Attempt to find within Main.
        $total          = $this->getConnection()
            ->table('item_db')
            ->select($columnList)
            ->where(['id'    => $id])
            ->count()
        ;

        if (!empty($total)) {
            return true;
        }

        return false;
    }


    public function countSpawned($id)
    {

    }

}