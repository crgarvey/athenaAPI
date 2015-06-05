<?php
/**
 * Created for Crewkie on 3/29/15.
 *
 * @author Robbie Vaughn
 */
namespace CrewkieApi\Model;

use DateTime;

class GameTimeclock extends Model
{
    protected $table        = 'cp_timeclock';
    protected $connection   = GAME_CONNECTION_NAME;
    public $timestamps      = false;
    protected $fillable     = ['*'];

    /**
     * Inverse of relationship with account
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(get_class(new GameAccount), 'account_id', 'account_id');
    }

    /**
     * Inverse of relationship with character
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(get_class(new GameCharacter), 'char_id', 'char_id');
    }

    /**
     * @return  integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return  DateTime
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @return  DateTime
     */
    public function getEndDate()
    {
        return $this->end_date;
    }
}