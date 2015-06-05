<?php
/**
 * Created for Crewkie on 3/29/15.
 *
 * @author Robbie Vaughn
 */
namespace CrewkieApi\Model\Game;

use Illuminate\Cache\Repository as Cache;
use CrewkieApi\Model\GameTimeclock;

class Timeclock
{
    const CACHE_EXPIRE_MINUTES = 30;
    const CACHE_KEY = 'timeclock.cache';

    /**
     * Timeclock Data
     *
     * @var     \CrewkieApi\Model\GameTimeclock[]
     */
    protected $timeclockData;

    /**
     * Cache
     *
     * @var     Cache
     */
    protected $cache;

    public function __construct(Cache $cache)
    {
        $this->cache            = $cache;
        $this->timeclockData    = $this->getCache();
    }

    /**
     * Retrieve data from the cache.
     *
     * @return  GameTimeclock[]
     */
    public function getCache()
    {
        return $this->cache->remember(self::CACHE_KEY, self::CACHE_EXPIRE_MINUTES, function() {
            return (new GameTimeclock)->orderBy('start_date', 'DESC')->get();
        });
    }

    /**
     * Find all data by criteria.
     *
     * @param       $staffName
     * @param       $startDate
     * @param       $endDate
     * @return      GameTimeclock[]
     */
    public function findAllBy(
        $staffName = null,
        $startDate = null,
        $endDate = null
    ) {
        // Create criteriaList.
        $data               = $this->timeclockData;
        $dataList           = [];

        $startTime          = strtotime($startDate);
        $endTime            = strtotime($endDate);

        // Iterate and build dataList
        foreach ($data as $d) {
            if (!empty($staffName) && $d->getName() != $staffName) {
                continue;
            }

            if (
                !empty($startDate) && !empty($endDate) &&
                !($startTime >= strtotime($d->getStartDate()) && $startTime <= strtotime($d->getEndDate())) &&
                !($endTime >= strtotime($d->getStartDate()) && $endTime <= strtotime($d->getEndDate()))
            ) {
                continue;
            }

            $dataList[$d->getId()]      = $d;
        }

        return $dataList;
    }
}