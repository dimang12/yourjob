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

class CategoriesTable extends SuperTableGateway {
    protected $tableGateway;
    protected $adapter;


    public function __construct(TableGateway $tableGateway){
        $this->tableGateway = $tableGateway;
        $this->adapter = $this->tableGateway->getAdapter();

        $this->_table = "categories";
        $this->_fieldId = "category_id";
        parent::__construct();
    }

    /*
     * get all categories of categories table
     */
    public function getAllCate($order=""){
        $db = new Sql($this->adapter);
        $sql =  $db->select()
                        ->from(array("c"=>"categories"))
                        ->columns(array("*",new Expression("count(job.job_id) AS num")))
                        ->join("job", new Expression("job.category_id = c.category_id AND DATE(job.job_close_date) > DATE(NOW())"),array(), "LEFT")
                        ->group("c.category_id")
                ;
        if(!empty($order)){
            $sql->order($order);
        }

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
            ->order("indu_name ASC")
        ;

        $statement  = $db->prepareStatementForSqlObject($sql);

        $resultSet = new ResultSet();
        return $resultSet->initialize($statement->execute())->buffer()->toArray();
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
    public function getJobByCate($cateId=null){
        $db = new Sql($this->adapter);
        $sql = $db->select()->from("job")
                    ->columns(array("*", new Expression("CASE WHEN (job_status = 1 AND job_status_approve = 0) THEN 4 ELSE job_status END AS job_status")))
                    ->join("city", "city.city_id = job.city_id")
                    ->join("company","job.user_id = company.user_id")
                    ->where("DATE(job.job_close_date) > DATE(NOW())")
                    ->order("job_status ASC")
                    ->order("job_published_date DESC")
                    ;
        ;
        if(!($cateId==null)){
            $sql->where("job.category_id = $cateId");
        }

        $statement = $db->prepareStatementForSqlObject($sql);
        $res = new ResultSet();
        return $res->initialize($statement->execute())->buffer()->toArray();
    }

    /**
     * get job between min and max salary
     * @param null $min
     * @param null $max
     * @return mixed
     */
    public function getJobBySalary($min=null, $max=null){
        $sql = $this->db->select()
                        ->from("job")
                        ->columns(array("*", new Expression("CASE WHEN (job_status = 1 AND job_status_approve = 0) THEN 4 ELSE job_status END AS job_status")))
                        ->join("city", "city.city_id = job.city_id")
                        ->join("company","job.user_id = company.user_id")
                        ->where("DATE(job.job_close_date) > DATE(NOW())")
                        ->order("job_status ASC")
                        ->order("job_published_date DESC")
            ;

        /*
         * if $min and $max not null
         * it will be filtered
         */
        if($min!=null && $max!=null){
            $sql->where("job_salary_from AND job_salary_to BETWEEN {$min} AND $max");
        }

        return $this->executeQuery($sql)->toArray();
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
            ->columns(array("job_id", "job_description","job_name"))
            ->where("job.category_id = $categoryId")
            ->where("DATE(job.job_close_date) > DATE(NOW())")
        ;
        $statement = $db->prepareStatementForSqlObject($sql);
        $res = new ResultSet();
        return $res->initialize($statement->execute())->buffer()->toArray();
    }

    public function getRelatedJob($companyId){
        $db = new Sql($this->adapter);
        $sql = $db->select()->from("job")
            ->columns(array("job_id","job_description", "job_name"))
            ->join("company", "job.user_id = company.user_id", array())
            ->where("company.company_id = $companyId")
            ->where("DATE(job.job_close_date) > DATE(NOW())")
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
            ->where("DATE(job.job_close_date) > DATE(NOW())")
        ;
        $statement = $db->prepareStatementForSqlObject($sql);
        $res = new ResultSet();
        return $res->initialize($statement->execute())->buffer()->toArray();
    }


} 