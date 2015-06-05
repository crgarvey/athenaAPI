<?php
/**
 * Created for Crewkie on 3/21/15.
 *
 * @author Robbie Vaughn
 */
namespace CrewkieApi\Model;

use DateTime;

class User extends UuidModel
{
    const LATESTAUTH_AT     = 'latestauth_at';
    protected $table        = 'user';
    protected $connection   = API_CONNECTION_NAME;
    public $timestamps      = false;
    protected $fillable     = ['*'];

    public function ipList()
    {
        return $this->hasMany(get_class(new UserIp), 'user_id', 'id');
    }

    /**
     * Returns an array of fields that should be converted to timestamps.
     *
     * @return array|void
     */
    public function getDates()
    {
        return [static::LATESTAUTH_AT];
    }

    /**
     * @return      string
     */
    public function getId()
    {
        return parent::getKey();
    }

    /**
     * @return      string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return      string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * @return      DateTime
     */
    public function getLatestAuthAt()
    {
        return $this->latestauth_at;
    }

}
