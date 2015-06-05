<?php
/**
 * Created for Crewkie on 3/21/15.
 *
 * @author Robbie Vaughn
 */
namespace CrewkieApi\Model;

class UserIp extends Model
{
    protected $table = 'user_ip';
    protected $connection = API_CONNECTION_NAME;

    public function user()
    {
        return $this->belongsTo(get_class(new User), 'id', 'user_id');
    }

    /**
     * @return      string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return      string
     */
    public function getIp()
    {
        return $this->ip;
    }
}