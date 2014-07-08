<?php 
namespace Production\Model;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Where;
class ProductTable extends AbstractTableGateway
{
	protected $tableGateway;
	public function __construct(TableGateway $tableGeteway){
		$this->tableGateway = $tableGeteway;
		$this->adapter= $this->tableGateway->getAdapter();
	}
	
	// Select category by parent id = 0
	public function getCate()
	{
		$sql = new Sql($this->adapter);
		$sqlObject = $sql->select("categories")->order("cate_order ASC");
		$row = $sql->prepareStatementForSqlObject($sqlObject)->execute();
		$resultSet = new ResultSet();
		return $result = $resultSet->initialize($row)->buffer()->toArray();
	}
	// get product id by product alias name
	public function getProductId($prodAlias)
	{
		$sql = new Sql($this->adapter);
		$sqlObject = $sql->select("products")->where("prod_alias = '$prodAlias'"); //from table products
		$row = $sql->prepareStatementForSqlObject($sqlObject)->execute();
		$resultSet = new ResultSet();
		return $result = $resultSet->initialize($row)->buffer()->toArray();
	}
	
	// get category id by cateAlias
	public function getCateId($cateAlias)
	{
		$sql = new Sql($this->adapter);
		$sqlObject = $sql->select("categories")->where("cate_alias = '$cateAlias'");
		$row = $sql->prepareStatementForSqlObject($sqlObject)->execute();
		$resultSet = new ResultSet();
		return $result = $resultSet->initialize($row)->buffer()->toArray();
	}
	
	public function getProduct()
	{
		$sql = new Sql($this->adapter);
		$select = $sql->select(array("p" => "products"))
		->join(array("i"=>"images"), "p.product_id = i.product_id")->where("p.prod_deal = 1 AND i.imag_status=1"); 
		$statement = $sql->prepareStatementForSqlObject($select)->execute();
		$resultSet = new ResultSet();
 		return $resultSet->initialize($statement)->buffer()->toArray();
 	}
	
 	public function getProdByCateId($cateId)
 	{
 		$sql = new Sql($this->adapter);
 		$select = $sql->select(array("p" => "products"))
 		->join(array("i"=>"images"), "i.product_id = p.product_id")->where("p.category_id=$cateId AND i.imag_status = 1");
 		$statement = $sql->prepareStatementForSqlObject($select)->execute();
 		$resultSet = new ResultSet();
 		return $resultSet->initialize($statement)->buffer();
 	}
 	
 	
// get cate 0
 	public function getCateZeroCount()
	{
		$sql = new Sql($this->adapter);
		$select = $sql->select('categories')->where("cate_parent=0");
		$statement = $sql->prepareStatementForSqlObject($select)->execute();
		$resultSet = new ResultSet();
		return $result = $resultSet->initialize($statement)->buffer()->toArray();
 	}
 	
 	// get new products
 	public function getProdNew($cateId)
 	{
 		$sql = new Sql($this->adapter);
 		$select  = $sql -> select(array('c'=>'categories'))
 		->join(array('p'=>'products'), "c.category_id = p.category_id")
 		->join(array('i'=>'images'), "p.product_id = i.product_id")
 		->where("p.category_id IN (select `category_id` from categories where cate_parent = '$cateId' AND i.imag_status=1)")
 		->order("p.product_id DESC");
//  		->where("p.category_id IN (select `category_id` from categories where cate_parent = '$cateId' AND imag_status=1)")
//  		->order("prod_deal DESC");
 		
 		$statement = $sql->prepareStatementForSqlObject($select)->execute();
 		$resultSet = new ResultSet();
 		return $result = $resultSet->initialize($statement)->buffer();
 	}
 	
 	
 	public function getInfo($cateId)
 	{
 		$sql = new Sql($this->adapter);
 		$sqlObject = $sql->select("information")->where("category_id=$cateId");
 		$row = $sql->prepareStatementForSqlObject($sqlObject)->execute();
 		$resultSet = new ResultSet();
 		return $result = $resultSet->initialize($row)->buffer()->toArray();
 	}
 	
 	public function getProdTitle($prodId)
 	{
 		$sql = new Sql($this->adapter);
 		$sqlObject = $sql->select("products")->where("product_id=$prodId");
 		$row = $sql->prepareStatementForSqlObject($sqlObject)->execute();
 		$resultSet = new ResultSet();
 		return $result = $resultSet->initialize($row)->buffer()->toArray();
 	}
 	
 	public function getImage($prodId)
 	{
 		$sql = new Sql($this->adapter);
 		$sqlObject = $sql->select("images")->where("product_id=$prodId AND imag_status=1");
 		$row = $sql->prepareStatementForSqlObject($sqlObject)->execute();
 		$resultSet = new ResultSet();
 		return $result = $resultSet->initialize($row)->buffer()->toArray();
 	}
 	public function getImages($prodId)
 	{
 		$sql = new Sql($this->adapter);
 		$sqlObject = $sql->select("images")->where("product_id=$prodId");
 		$row = $sql->prepareStatementForSqlObject($sqlObject)->execute();
 		$resultSet = new ResultSet();
 		return $result = $resultSet->initialize($row)->buffer()->toArray();
 	}
 	//get specification
 	public function getSpecification($cateId)
 	{
 		$sql = new Sql($this->adapter);
 		$select = $sql->select(array('cs' => 'categories_specification'))
 		->join(array('sp' => 'specification'), 'cs.specification_id = sp.specification_id')
 		->where("cs.category_id= $cateId");
 		$statement = $sql->prepareStatementForSqlObject($select)->execute();
 		$resultSet = new ResultSet();
 		return $result = $resultSet->initialize($statement)->buffer();
 	}

 	//get standard
 	public function getStandard($cateId)
 	{
 		$sql = new Sql($this->adapter);
 		$select  = $sql->select(array('cs'=>'categories_standard'))
 		->join(array('s'=> 'standard'), 'cs.standard_id = s.standard_id')
 		->where("cs.category_id = $cateId");
 		$statement = $sql->prepareStatementForSqlObject($select)->execute();
 		$resultSet = new ResultSet();
 		return $result = $resultSet->initialize($statement)->buffer();
 	}
 	
 	//get technical
 	public function getTechnical($cateId)
 	{
 		$sql = new Sql($this->adapter);
 		$sqlObject = $sql->select("technical")->where("category_id=$cateId");
 		$row = $sql->prepareStatementForSqlObject($sqlObject)->execute();
 		$resultSet = new ResultSet();
 		return $result = $resultSet->initialize($row)->buffer()->toArray();
 	}
 	
}