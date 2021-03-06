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
use Application\Model\DB;

class EducationTable extends SuperTableGateway{

    protected $tableGateway;
    protected $adapter;

    public function __construct($adapter){
        $this->adapter = $adapter;
        $this->_table = "education";
        $this->_fieldId = "education_id";
        parent::__construct($adapter);

    }

    /*
     * get all education that not expired
     * order by latest post
     * return array of values
     */
    public function getAllEducation(){
        $db = new Sql($this->adapter);
        $sql = $db->select()
                    ->from("education")
                    ->columns(array("*",new Expression("LEFT(educ_detail,200) AS detail")))
                    ->where("educ_approval=1")
                    ->order("educ_post_date DESC");

        return DB::executeQuery($db, $sql)->toArray();
    }

    /*
     * get latest education
     * order by latest posted
     * @return array of values
     */
    public function getLatestEducation($limit = 10){
        $db = new Sql($this->adapter);
        $sql = $db->select()
                  ->columns(array("educ_title","education_id","educ_img"))
                  ->from("education")
                  ->order("educ_post_date")
                  ->where("educ_approval=1")
                  ->limit($limit)
            ;

        return Db::executeQuery($db, $sql)->toArray();
    }


    public function getEducationCategory(){
        $sql = $this->db->select()->from("education_category")->order("edca_name ASC");
        return $this->executeQuery($sql)->toArray();
    }




}