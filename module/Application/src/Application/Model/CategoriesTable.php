<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 6/1/14
 * Time: 1:14 PM
 */

namespace Application\Model;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

class CategoriesTable extends AbstractTableGateway {
    protected $tableGateway;
    protected $adapter;

    public function __construct(TableGateway $tableGateway){
        $this->tableGateway = $tableGateway;
        $this->adapter = $this->tableGateway->getAdapter();
    }

    /*
     * get all categories of categories table
     */
    public function getAllCate(){
        $db = new Sql($this->adapter);
        $sql =  $db->select()->from("categories");


        $statement  = $db->prepareStatementForSqlObject($sql);


        $resultSet = new ResultSet();
        return $resultSet->initialize($statement->execute())->buffer();

    }


    /*
     *
     */
    public function getJobByCate($cateId){
        $db = new Sql($this->adapter);
        $sql = $db->select()->from("job")
                    ->join("job_category","job_category.job_id = job.job_id")
                    ->join("city", "city.city_id = job.city_id")
                    ->join("company","job.user_id = company.user_id");
        ;
        $statement = $db->prepareStatementForSqlObject($sql);
        $res = new ResultSet();
        return $res->initialize($statement->execute())->buffer();
    }

    /*
     * get job detail
     */

    public function getJobDetail($jobId){
        $db = new Sql($this->adapter);
        $sql = $db->select()->from("job")
                ->join("job_category","job_category.job_id = job.job_id")
                ->join("city", "city.city_id = job.city_id")
                ->join("company","job.user_id = company.user_id")
                ->where("job.job_id = $jobId")
        ;
        $statement = $db->prepareStatementForSqlObject($sql);
        $res = new ResultSet();
        return $res->initialize($statement->execute())->buffer()->toArray();
    }
} 