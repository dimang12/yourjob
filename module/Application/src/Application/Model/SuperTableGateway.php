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
    public $_table = "";
    public $_fieldId = "";

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

    /*
     * save data table
     * @return last inserted id
     */
    public function save($values){
        $sql = $this->db->insert($this->_table)->values($values);
        return $this->execute($sql);
    }

    /*
     * delete row of table
     * no return value
     */
    public function deleteRow($id){
        $sql = $this->db->delete($this->_table)->where($this->_fieldId ."=" .$id);
        $this->execute($sql);
    }

    /*
     * update row of table
     * no return values
     */
    public function updateRow($values, $id){
        $sql = $this->db->update($this->_table)->set($values)->where($this->_fieldId. "=" .$id);
        $this->execute($sql);
    }



}