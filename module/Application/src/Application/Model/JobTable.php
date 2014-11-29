<?php
/**
 * User: dimang12
 * Date: 8/30/14
 * Time: 3:22 PM
 */
namespace Application\Model;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;


class JobTable extends SuperTableGateway{

    protected $tableGateway;
    protected $adapter;

    public function __construct($adapter){
        $this->adapter = $adapter;
        $this->_table = "job";
        $this->_fieldId = "job_id";
        parent::__construct($adapter);
    }


    /*
     * search from job
     * @return array of jobs
     */
    public function search($searchText){

        $sql = $this->db->select()
                    ->from("job")
                    ->join(array("c"=>"categories"), "job.category_id=c.category_id")
                    ->join(array("com"=>"company"), "job.user_id=com.user_id")
                    ->join(array("ci"=>"city"), "job.city_id=ci.city_id")
                    ->where("job_name LIKE '%$searchText%' OR com_name LIKE '%$searchText%' or city_name LIKE '%$searchText%'")
//                    ->where(" job_close_date > NOW() ")
            ;

        return $this->executeQuery($sql)->toArray();
    }

    /*
     * search from job
     */
    public function livesearch($searchText){
        $sql = $this->db->select()
                    ->columns(array("label"=>"job_name"))
                    ->from("job")
                    ->where("job_name LIKE '%$searchText%'")
            ;
        return $this->executeQuery($sql)->toArray();
    }
}