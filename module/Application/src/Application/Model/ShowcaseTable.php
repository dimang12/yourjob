<?php
namespace Application\Model;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
class ShowcaseTable extends AbstractTableGateway
{
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
		$this->adapter = $this->tableGateway->getAdapter();
	}
	
	//get image thumb showcase
	public function getShowcase()
	{
		$sql= new Sql($this->adapter);
		$select = $sql->select('showcase');
		$statement =$sql->prepareStatementForSqlObject($select)->execute();
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	}
	
	// get default scene of showcase
	public function getDefaultScene()
	{
		$sql =new Sql($this->adapter);
		$select = $sql->select('showcase_scene')->where('showcase_id=1');
		$statement = $sql->prepareStatementForSqlObject($select)->execute();
		
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	}
	
	//get image id by image title
	
	public function getShowcaseId($showImage)
	{
		$sql= new Sql($this->adapter);
		$select = $sql->select('showcase')->where("show_image='$showImage'");
		$statement =$sql->prepareStatementForSqlObject($select)->execute();
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	}
	
	//get showcase scene by showcaseId
	public function getShowcaseScene($showcaseId)
	{
		$sql= new Sql($this->adapter);
		$select = $sql->select('showcase_scene')->where("showcase_id='$showcaseId'");
		$statement =$sql->prepareStatementForSqlObject($select)->execute();
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	}

}