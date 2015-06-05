<?php
/**
 * Created for Crewkie on 4/2/15.
 *
 * @author Robbie Vaughn
 */
namespace CrewkieApi\Model;

class GameItemDbCustom extends Model
{
    protected $table        = 'item_db2';
    protected $connection   = GAME_CONNECTION_NAME;
    public $timestamps      = false;
    protected $fillable     = ['*'];
}
