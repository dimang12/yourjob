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
} 