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
        $sql = $db->select()->from("education")->order("educ_post_date DESC");

        return DB::executeQuery($db, $sql);
    }

}