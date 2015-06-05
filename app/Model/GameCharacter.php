<?php
/**
 * Created for Crewkie on 3/29/15.
 *
 * @author Robbie Vaughn
 */
namespace CrewkieApi\Model;

use DateTime;

class GameCharacter extends Model
{
    protected $table        = 'char';
    protected $connection   = GAME_CONNECTION_NAME;
    public $timestamps      = false;
    protected $fillable     = ['*'];

    /**
     * Relationship with timeclock
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timeclockList()
    {
        return $this->hasMany(get_class(new GameTimeclock()), 'char_id', 'char_id');
    }
}
