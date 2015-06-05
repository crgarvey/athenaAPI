<?php
/**
 * Created for Crewkie on 4/2/15.
 *
 * @author Robbie Vaughn
 */
namespace CrewkieApi\Model;

class GameItemDb extends Model
{
    protected $table        = 'item_db';
    protected $connection   = GAME_CONNECTION_NAME;
    public $timestamps      = false;
    protected $fillable     = ['*'];
}