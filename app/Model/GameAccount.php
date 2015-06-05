<?php
/**
 * Created for Crewkie on 3/22/15.
 *
 * @author Robbie Vaughn
 */
namespace CrewkieApi\Model;

use DateTime;

class GameAccount extends Model
{
    protected $table        = 'login';
    protected $connection   = GAME_CONNECTION_NAME;
    public $timestamps      = false;
    protected $fillable     = ['*'];

    /**
     * Relationship with timeclock
     *
     * @return      \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timeclockList()
    {
        return $this->hasMany(get_class(new GameTimeclock()), 'account_id', 'account_id');
    }
}
