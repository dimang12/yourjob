<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 10/12/14
 * Time: 10:02 AM
 */

namespace Application\Model;


use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;

class SuperTableGateway extends TableGateway{

    public $db;

    public function __construct($adapter){
        $this->db = new Sql($adapter);
    }

    public function executeQuery($sql){
        return DB::executeQuery($this->db, $sql);
    }

    /*
     * execute sql statement
     * @return last inserted id
     */
    public function execute($sql){
        $inserted = $this->db->prepareStatementForSqlObject($sql)->execute();
        return $inserted->getGeneratedValue();
    }


}