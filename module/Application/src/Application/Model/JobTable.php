<?php
/**
 * User: dimang12
 * Date: 8/30/14
 * Time: 3:22 PM
 */
namespace Application\Model;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;


class JobTable extends AbstractTableGateway{

    protected $tableGateway;
    protected $adapter;

    public function __construct(TableGateway $tableGateway){
        $this->tableGateway = $tableGateway;
        $this->adapter = $this->tableGateway->getAdapter();
    }

    /*
     * search from job
     */
    public function search($searchText){
        $db = new Sql($this->adapter);
        $sql = $db->select()
                    ->columns(array("label"=>"job_name"))
                    ->from("job")
                    ->where("job_name LIKE '%$searchText%'")
            ;

        $statement  = $db->prepareStatementForSqlObject($sql);

        $resultSet = new ResultSet()    ;
        return $resultSet->initialize($statement->execute())->buffer()->toArray();
    }
}