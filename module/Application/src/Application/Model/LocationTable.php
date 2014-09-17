<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 9/11/14
 * Time: 11:08 AM
 */
namespace Application\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Predicate\Expression;

class LocationTable extends TableGateway{

    protected $tableGateway;
    protected $adapter;

    public function __construct($adapter){
        $this->adapter = $adapter;
    }

    /*
     * get all location and count jobs
     * return array of data
     */
    public function getAllLocationJobs(){
        $db = new Sql($this->adapter);
        $query = $db->select()
                    ->from("city")
                    ->columns(array("*",new Expression("count(job.job_id) AS num")))
                    ->join("job", "city.city_id=job.city_id",array(), "LEFT")
                    ->group("city.city_id")
                    ;
        return DB::executeQuery($db, $query)->toArray();
    }

    /*
     * get jobs by city id
     * return array of data
     */
    public function getJobByCity($cityId){
        $db = new Sql($this->adapter);
        $sql = $db->select()->from("job")
            ->join("city", "city.city_id = job.city_id")
            ->join("company","job.user_id = company.user_id")
            ->where("job.city_id = $cityId")
            ->order("job_status ASC")
        ;

        return DB::executeQuery($db, $sql)->toArray();
    }

    /*
     * get location by id
     * return current array of data
     */
    public function getLocation($cityId){
        $db = new Sql($this->adapter);
        $query = $db->select()
                    ->from("city")
                    ->where("city_id = $cityId")
                    ->limit(1)
            ;
        return DB::executeQuery($db, $query)->current();
    }


}