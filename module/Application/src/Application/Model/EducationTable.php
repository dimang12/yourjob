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

class EducationTable extends TableGateway{

    protected $tableGateway;
    protected $adapter;

    public function __construct($adapter){
        $this->adapter = $adapter;
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
                    ->order("educ_post_date DESC");

        return DB::executeQuery($db, $sql);
    }

    /*
     * get latest education
     * order by latest posted
     * @return array of values
     */
    public function getLatestEducation($limit = 10){
        $db = new Sql($this->adapter);
        $sql = $db->select()
                  ->columns(array("educ_title"))
                  ->from("education")
                  ->order("educ_post_date")
                  ->limit($limit)
            ;

        return Db::executeQuery($db, $sql)->toArray();
    }

}