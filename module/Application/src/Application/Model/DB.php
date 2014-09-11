<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 9/11/14
 * Time: 11:49 AM
 */
namespace Application\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;

class DB{

    public function __construct(){

    }

    public static  function executeQuery(Sql $db, $sql){
        $statement = $db->prepareStatementForSqlObject($sql);
        $rs = new ResultSet();
        return $rs->initialize($statement->execute())->buffer();
    }
}