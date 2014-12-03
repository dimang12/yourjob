<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 6/1/14
 * Time: 1:14 PM
 */

namespace Application\Model;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Predicate\Expression;
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
        $sql =  $db->select()
                        ->from(array("c"=>"categories"))
                        ->columns(array("*",new Expression("count(job.job_id) AS num")))
                        ->join("job", "job.category_id = c.category_id",array(), "LEFT")
                        ->group("c.category_id")
                ;

        $statement  = $db->prepareStatementForSqlObject($sql);

        $resultSet = new ResultSet();
        return $resultSet->initialize($statement->execute())->buffer();

    }

    public function getCategories(){
        $db = new Sql($this->adapter);
        $sql = $db->select()
                    ->from("categories")
                    ->order("cate_name")
                ;
        return DB::executeQuery($db,$sql)->toArray();
    }

    public function getAllIndustries(){
        $db = new Sql($this->adapter);
        $sql =  $db->select()
            ->from(array("c"=>"industries"))
            ->columns(array("*",new Expression("count(job.job_id) AS num")))
            ->join("job", "job.industry_id = c.industry_id",array(), "LEFT")
            ->group("c.industry_id")
        ;

        $statement  = $db->prepareStatementForSqlObject($sql);

        $resultSet = new ResultSet();
        return $resultSet->initialize($statement->execute())->buffer();
    }

    public function getCategoryById($cateId){
        $db = new Sql($this->adapter);
        $sql = $db->select()
                    ->from("categories")
            ;
    }


    /*
     *
     */
    public function getJobByCate($cateId){
        $db = new Sql($this->adapter);
        $sql = $db->select()->from("job")
                    ->join("city", "city.city_id = job.city_id")
                    ->join("company","job.user_id = company.user_id")
                    ->where("job.category_id = $cateId")
                    ->order("job_status ASC")
                    ;
        ;
        $statement = $db->prepareStatementForSqlObject($sql);
        $res = new ResultSet();
        return $res->initialize($statement->execute())->buffer()->toArray();
    }

    /*
     * get job detail
     */

    public function getJobDetail($jobId){
        $db = new Sql($this->adapter);
        $sql = $db->select()->from("job")
                ->join("categories","categories.category_id = job.category_id")
                ->join("city", "city.city_id = job.city_id")
                ->join("company","job.user_id = company.user_id")
                ->where("job.job_id = $jobId")
        ;
        $statement = $db->prepareStatementForSqlObject($sql);
        $res = new ResultSet();
        return $res->initialize($statement->execute())->buffer()->toArray();
    }

    /*
     *
     */

    public function getRecommendedJob($categoryId){
        $db = new Sql($this->adapter);
        $sql = $db->select()->from("job")
            ->where("job.category_id = $categoryId")
        ;
        $statement = $db->prepareStatementForSqlObject($sql);
        $res = new ResultSet();
        return $res->initialize($statement->execute())->buffer()->toArray();
    }

    public function getRelatedJob($companyId){
        $db = new Sql($this->adapter);
        $sql = $db->select()->from("job")
            ->join("company","job.user_id = company.user_id")
            ->where("job.category_id = $companyId")
        ;
        $statement = $db->prepareStatementForSqlObject($sql);
        $res = new ResultSet();
        return $res->initialize($statement->execute())->buffer()->toArray();
    }



    /*
     * get newest jobs
     */
    public function getNewestJob(){
        $db = new Sql($this->adapter);
        $sql = $db->select()
            ->columns(array("job_id","job_name"))
            ->from("job")
            ->join("company","job.user_id = company.user_id",array("com_info"))
            ->where("job_status=1")
        ;
        $statement = $db->prepareStatementForSqlObject($sql);
        $res = new ResultSet();
        return $res->initialize($statement->execute())->buffer()->toArray();
    }
} 