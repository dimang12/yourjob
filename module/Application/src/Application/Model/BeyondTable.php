<?php
namespace Application\Model;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
class BeyondTable extends AbstractTableGateway
{
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
		$this->adapter = $this->tableGateway->getAdapter();
	}
	
	//get exterior & Interior
	public function getLiving()
	{
		$sql = new Sql($this->adapter);
		$select = $sql->select('living');
		$row = $sql->prepareStatementForSqlObject($select)->execute();
		
		$resultSet  = new ResultSet();
		return $resultSet->initialize($row)->buffer()->toArray();
	}
	
	//get beyond living limit 3
	public function getBeyond()
	{
		$sql = new Sql($this->adapter);
		$select = $sql->select('living')->where('live_parent !=0')->limit(3);
		$row = $sql->prepareStatementForSqlObject($select)->execute();

		$resultSet  = new ResultSet();
		return $resultSet->initialize($row)->buffer()->toArray();
	}
}