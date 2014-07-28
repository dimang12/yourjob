<?php

namespace Admin\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Adapter;

class GlobalModel extends AbstractTableGateway {
	protected $table;
	public function __construct(TableGateway $table) {
		$this->table = $table;
		$this->adapter = $this->table->getAdapter ();
	}
	
	// upload image showcase function
	public function uploadImageShowcase($file) {
		$file = array (
				'show_image' => $file ['show_image'],
				'show_title' => $file ['show_title'] 
		);
		
		if (! empty ( $file )) {
			$sql = new Sql ( $this->adapter );
			$insert = $sql->insert ( 'showcase' )->values ( $file );
			return $sql->prepareStatementForSqlObject ( $insert )->execute ();
		}
	}
	public function resizeImage($width, $height, $dir, $fileType, $newfile) {
		$imagePath = "public/img/showcase/large/" . $newfile;
		list ( $w, $h ) = getimagesize ( $imagePath );
		$width = ( int ) (($height / $h) * $w);
		$ratio = max ( $width / $w, $height / $h );
		$h = ceil ( $height / $ratio );
		$x = ($w - $width / $ratio) / 2;
		$w = ceil ( $width / $ratio );
		
		$folder = 'large';
		if ($height == 80) {
			$path = 'public/img/showcase/small/' . $newfile;
			$folder = 'small';
		} else {
			$path = 'public/img/showcase/large/' . $newfile;
		}
		
		$imgString = file_get_contents ( $imagePath );
		$image = imagecreatefromstring ( $imgString );
		$tmp = imagecreatetruecolor ( $width, $height );
		
		// get extension of image
		$ext = pathinfo ( $newfile, PATHINFO_EXTENSION );
		if ($ext == 'gif' or $ext == 'png') {
			imagecolortransparent ( $tmp, imagecolorallocatealpha ( $tmp, 0, 0, 0, 127 ) );
			imagealphablending ( $tmp, false );
			imagesavealpha ( $tmp, true );
		}
		imagecopyresampled ( $tmp, $image, 0, 0, $x, 0, $width, $height, $w, $h );
		switch ($fileType) {
			case 'image/jpeg' :
				imagejpeg ( $tmp, $path, 100 );
				break;
			case 'image/png' :
				imagepng ( $tmp, $path, 0 );
				break;
			case 'image/gif' :
				imagegif ( $tmp, $path );
				break;
			default :
				exit ();
				break;
		}
		/* cleanup memory */
		imagedestroy ( $image );
		imagedestroy ( $tmp );
	}
	public function scaleImage($width, $height,$dir, $fileType, $newfile){
		$imagePath = "public/img/products/l/".$newfile;
		list($w, $h) = getimagesize($imagePath);
		$width = (int)(($height / $h) * $w);
		$ratio = max($width/$w, $height/$h);
		$h = ceil($height / $ratio);
		$x = ($w - $width / $ratio) / 2;
		$w = ceil($width / $ratio);
		$folder = 'm';
		if($height == 80){
			$path = 'public/img/products/s/'.$newfile;
			$folder = 's';
		}else{
			$path = 'public/img/products/m/'.$newfile;
		}		
	
		$imgString = file_get_contents($imagePath);
		$image = imagecreatefromstring($imgString);
		$tmp = imagecreatetruecolor($width, $height);
	
		//get extension of image
		$ext = pathinfo($newfile, PATHINFO_EXTENSION);
		if($ext == 'gif' or $ext == 'png'){
			imagecolortransparent($tmp, imagecolorallocatealpha($tmp, 0, 0, 0, 127));
			imagealphablending($tmp, false);
			imagesavealpha($tmp, true);
		}
		imagecopyresampled($tmp, $image, 0, 0, $x, 0, $width, $height, $w, $h);
		switch ($fileType){
			case 'image/jpeg':
				imagejpeg($tmp, $path, 100);
				break;
			case 'image/png':
				imagepng($tmp, $path, 0);
				break;
			case 'image/gif':
				imagegif($tmp, $path);
				break;
			default:
				exit;
				break;
		}
		/* cleanup memory */
		imagedestroy($image);
		imagedestroy($tmp);
	}
	// display all image that have been upload ...
	public function getShowcaseImage() {
		$sql = new Sql ( $this->adapter );
		$se = $sql->select ( 'showcase' )->order ( 'showcase_id DESC' );
		$st = $sql->prepareStatementForSqlObject ( $se )->execute ();
		
		// convert to array
		$rs = new ResultSet ();
		return $rs->initialize ( $st )->buffer ()->toArray ();
	}
	
	// delete showcase by showcase Id
	public function deleteShowcaseById($Id) {
		if (! empty ( $Id )) {
			$sql = new Sql ( $this->adapter );
			$delete = $sql->delete ( 'showcase' )->where ( "showcase_id = $Id" );
			$sql->prepareStatementForSqlObject ( $delete )->execute ();
			
			$delete = $sql->delete ( 'showcase_scene' )->where ( "showcase_id = $Id" );
			$sql->prepareStatementForSqlObject ( $delete )->execute ();
		}
	}
	
	// check image if existing to unlink folder direct file
	public function checkExistImage($Id) {
		if (! empty ( $Id )) {
			$sql = new Sql ( $this->adapter );
			$se = $sql->select ( 'showcase' )->where ( "showcase_id= $Id" );
			$st = $sql->prepareStatementForSqlObject ( $se )->execute ();
			
			$rs = new ResultSet ();
			return $rs->initialize ( $st )->buffer ()->toArray ();
		}
	}
	
	// insert data customize image to create scene
	public function SaveCustomize($v, $id) {
		$data = array (
				'showcase_id' => $v ['showcase_id'],
				'scen_desc' => $v ['scen_desc'],
				'prod_alias' => $v ['prod_alias'],
				// 'scen_left'=>$v['scen_left'],
				// 'scen_top'=>$v['scen_top'],
				'scen_placement' => $v ['scen_placement'],
				'scen_skewx' => $v ['scen_skewx'],
				'scen_skewy' => $v ['scen_skewy'] 
		);
		if (! empty ( $data )) {
			$sql = new Sql ( $this->adapter );
			$insert = $sql->update ( 'showcase_scene' )->set ( $data )->where ( "scene_id=$id" );
			return $sql->prepareStatementForSqlObject ( $insert )->execute ();
		}
	}
	public function createscene($data) {
		if (! empty ( $data )) {
			$values = array (
					'showcase_id' => $data ['showcase_id'] 
			);
			$sql = new Sql ( $this->adapter );
			$insert = $sql->insert ( 'showcase_scene' )->values ( $values );
			return $sql->prepareStatementForSqlObject ( $insert )->execute ();
		}
	}
	
	// get all scene
	public function getScene($id) {
		if (! empty ( $id )) {
			$sql = new Sql ( $this->adapter );
			$se = $sql->select ( 'showcase_scene' )->where ( "showcase_id=$id" );
			$st = $sql->prepareStatementForSqlObject ( $se )->execute ();
			
			// convert to array
			$rs = new ResultSet ();
			return $rs->initialize ( $st )->buffer ()->toArray ();
		}
	}
	
	// update scene on drop
	public function updateondrop($Id, $data) {
		if (! empty ( $Id )) {
			$sql = new Sql ( $this->adapter );
			$update = $sql->update ( 'showcase_scene' )->set ( $data )->where ( "scene_id = $Id" );
			$statement = $sql->prepareStatementForSqlObject ( $update )->execute ();
		}
	}
	
	// Display image of Byond Living
	public function getBeyondLivingImage() {
		$sql = new Sql ( $this->adapter );
		$se = $sql->select ( 'living' )->order ( 'living_id DESC' );
		$st = $sql->prepareStatementForSqlObject ( $se )->execute ();
		
		// convert to array
		$rs = new ResultSet ();
		return $rs->initialize ( $st )->buffer ()->toArray ();
	}
	public function resizeImageLiving($width, $height, $dir, $fileType, $newfile) {
		$imagePath = "public/img/beyond/original/" . $newfile;
		list ( $w, $h ) = getimagesize ( $imagePath );
		$width = ( int ) (($height / $h) * $w);
		$ratio = max ( $width / $w, $height / $h );
		$h = ceil ( $height / $ratio );
		$x = ($w - $width / $ratio) / 2;
		$w = ceil ( $width / $ratio );
		
		$folder = 'original';
		if ($height == 80) {
			$path = 'public/img/beyond/small/' . $newfile;
			$folder = 'small';
		} else {
			$path = 'public/img/beyond/original/' . $newfile;
		}
		
		$imgString = file_get_contents ( $imagePath );
		$image = imagecreatefromstring ( $imgString );
		$tmp = imagecreatetruecolor ( $width, $height );
		
		// get extension of image
		$ext = pathinfo ( $newfile, PATHINFO_EXTENSION );
		if ($ext == 'gif' or $ext == 'png') {
			imagecolortransparent ( $tmp, imagecolorallocatealpha ( $tmp, 0, 0, 0, 127 ) );
			imagealphablending ( $tmp, false );
			imagesavealpha ( $tmp, true );
		}
		imagecopyresampled ( $tmp, $image, 0, 0, $x, 0, $width, $height, $w, $h );
		switch ($fileType) {
			case 'image/jpeg' :
				imagejpeg ( $tmp, $path, 100 );
				break;
			case 'image/png' :
				imagepng ( $tmp, $path, 0 );
				break;
			case 'image/gif' :
				imagegif ( $tmp, $path );
				break;
			default :
				exit ();
				break;
		}
		/* cleanup memory */
		imagedestroy ( $image );
		imagedestroy ( $tmp );
	}
	//upload image Beyond Living function
	public function uploadImageBeyondLiving($file)
	{
		$file = array('live_image'=>$file['show_image'], 'live_title'=>$file['live_title'],'kh_live_title'=>$file['kh_live_title'],'live_desc'=>$file['live_desc'],'kh_live_desc'=>$file['kh_live_desc'],'live_parent'=>$file['live_parent']);
			
		if(!empty($file))
		{
			$sql = new Sql($this->adapter);
			$insert = $sql->insert('living') ->values($file);
			return $sql->prepareStatementForSqlObject($insert)->execute();
		}
	}
	
	// get cate by cate
	public function getCate() {
		$sql = new Sql ( $this->adapter );
		$s = $sql->select ( 'categories' );
		$st = $sql->prepareStatementForSqlObject ( $s )->execute ();
		
		$rs = new ResultSet ();
		return $rs->initialize ( $st )->buffer ()->toArray ();
	}
	
	// save cate 0
	public function saveCate($d) {
		$data = array (
				'cate_parent' => $d ['cate_parent'],
				'cate_name' => $d ['cate_name'],
				'cate_alias' => $d ['cate_alias'],
				'kh_cate_name' => $d ['kh_cate_name'],
				'cate_order' => $d ['cate_order'],
				'cate_details' => $d ['cate_details'],
				'kh_cate_details' => $d ['kh_cate_details'],
				'cate_image' => $d ['cate_image'] 
		);
		
		if (! empty ( $data )) {
			$sql = new Sql ( $this->adapter );
			$i = $sql->insert ( 'categories' )->values ( $data );
			$sql->prepareStatementForSqlObject ( $i )->execute ();
		}
	}
	
	// getcateByid
	public function getCateById($id) {
		if (! empty ( $id )) {
			$sql = new Sql ( $this->adapter );
			$s = $sql->select ( 'categories' )->where ( "category_id=$id" );
			$st = $sql->prepareStatementForSqlObject ( $s )->execute ();
			$rs = new ResultSet ();
			return $rs->initialize ( $st )->buffer ();
		}
	}
	
	// update cate
	public function updateCate($id, $d) {
		$data = array (
				'cate_parent' => $d ['cate_parent'],
				'cate_name' => $d ['cate_name'],
				'cate_alias' => $d ['cate_alias'],
				'kh_cate_name' => $d ['kh_cate_name'],
				'cate_order' => $d ['cate_order'],
				'cate_details' => $d ['cate_details'],
				'kh_cate_details' => $d ['kh_cate_details'],
				'cate_image' => $d ['cate_image'] 
		);
		
		if (! empty ( $data )) {
			$sql = new Sql ( $this->adapter );
			$u = $sql->update ( 'categories' )->set ( $data )->where ( "category_id=$id" );
			$sql->prepareStatementForSqlObject ( $u )->execute ();
		}
	}
	// update cate no image
	public function updateCateNoImage($id, $d) {
		$data = array (
				'cate_parent' => $d ['cate_parent'],
				'cate_name' => $d ['cate_name'],
				'cate_alias' => $d ['cate_alias'],
				'kh_cate_name' => $d ['kh_cate_name'],
				'cate_order' => $d ['cate_order'],
				'cate_details' => $d ['cate_details'],
				'kh_cate_details' => $d ['kh_cate_details'],
		);
	
		if (! empty ( $data )) {
			$sql = new Sql ( $this->adapter );
			$u = $sql->update ( 'categories' )->set ( $data )->where ( "category_id=$id" );
			$sql->prepareStatementForSqlObject ( $u )->execute ();
		}
	}
	//delete cate
	public function deleteCate($id)
	{
		if(!empty($id))
		{
			$sql = new Sql ( $this->adapter );
			$remove= $sql->delete ( 'categories' )->where ( "category_id=$id OR cate_parent=$id" );
			$sql->prepareStatementForSqlObject ( $remove )->execute ();
			
			$remove= $sql->delete ( 'products' )->where ( "category_id=$id" );
			$sql->prepareStatementForSqlObject ( $remove )->execute ();
		}
	}
	
	// save sub cate
	public function saveSubCate($d) {
		$data = array (
				'cate_parent' => $d ['cate_parent'],
				'cate_name' => $d ['cate_name'],
				'cate_alias' => $d ['cate_alias'],
				'kh_cate_name' => $d ['kh_cate_name'],
				'cate_order' => $d ['cate_order'],
				'cate_details' => $d ['cate_details'],
				'kh_cate_details' => $d ['kh_cate_details'],
		);
		
		if (! empty ( $data )) {
			$sql = new Sql ( $this->adapter );
			$i = $sql->insert ( 'categories' )->values ( $data );
			$sql->prepareStatementForSqlObject ( $i )->execute ();
		}
	}
	
	// edit sub catt
	public function editSubCate($d, $id) {
		$data = array (
				'cate_parent' => $d ['cate_parent'],
				'cate_name' => $d ['cate_name'],
				'cate_alias' => $d ['cate_alias'],
				'kh_cate_name' => $d ['kh_cate_name'],
				'cate_order' => $d ['cate_order'],
				'cate_details' => $d ['cate_details'],
				'kh_cate_details' => $d ['kh_cate_details'],
		);
	
		if (! empty ( $data )) {
			$sql = new Sql ( $this->adapter );
			$i = $sql->update ( 'categories' )->set ( $data )->where("category_id=$id");
			$sql->prepareStatementForSqlObject ( $i )->execute ();
		}
	}
	
	//remove scene
	public function removeSceneById($id)
	{
		if(!empty($id))
		{
			$sql = new Sql ( $this->adapter );
			$delete = $sql->delete ( 'showcase_scene' )->where ( "scene_id = $id" );
			$sql->prepareStatementForSqlObject ( $delete )->execute ();
		}
	}
	//  Update Beyond Linving
	public function updateImageBeyondLiving($dataUpate){
		$id = $dataUpate['living_id'];
		$data = array('live_title'=>$dataUpate['live_title'],'kh_live_title'=>$dataUpate['kh_live_title'],'live_desc'=>$dataUpate['live_desc'],'kh_live_desc'=>$dataUpate['kh_live_desc'],'live_parent'=>$dataUpate['live_parent']);
		if(!empty($data)){
			$sql=new Sql($this->adapter);
			$update = $sql->update('living')->set($data)->where(array('living_id'=>$id));
			return $sql->prepareStatementForSqlObject($update)->execute();
		}
	}
	// Ceck Exist Image Beyond Living
	public function checkExistImageBeyondLiving($Id)
	{
		if(!empty($Id))
		{
			$sql = new Sql($this->adapter);
			$se = $sql->select('living')->where("living_id= $Id");
			$st = $sql->prepareStatementForSqlObject($se)->execute();
	
			$rs = new ResultSet();
			return $rs->initialize($st)->buffer()->toArray();
		}
	}
	//delete Beyond Living by Id
	public function deleteBeyondById($Id)
	{
		if(!empty($Id)){
			$sql = new Sql($this->adapter);
			$delete = $sql->delete('living')->where("living_id = $Id");
			$sql->prepareStatementForSqlObject($delete)->execute();
		}
	}
	//get beyondliving by id
	public function getBeyondLivingById($Id)
	{
		$sql = new Sql($this->adapter);
		$object = $sql->select('living')->where("living_id=$Id");
		$statement = $sql->prepareStatementForSqlObject($object)->execute();
	
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	
	}
	// Insert parent Beyond living
	public function InsertParentBeyondLiving($getData)
	{
		$data = array('live_parent'=>'0','live_title'=>$getData['live_title'],'kh_live_title'=>$getData['kh_live_title']);
		if(!empty($data))
		{
			$sql = new Sql($this->adapter);
			$insert = $sql->insert('living') ->values($data);
			return $sql->prepareStatementForSqlObject($insert)->execute();
		}
	} 
	// Get live parent 
	public function getLiveParent()
	{
		$sql = new Sql($this->adapter);
		$object = $sql->select('living')->where("live_parent=0");
		$statement = $sql->prepareStatementForSqlObject($object)->execute();
		
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	}
	//get products
	public function getProduct()
	{
		$sql = new Sql($this->adapter);
		$object = $sql->select('products');
		$statement = $sql->prepareStatementForSqlObject($object)->execute();
	
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	
	}
	
	//save new product
	public function saveproduct($field)
	{
		$values = array(
				'category_id'	=>$field['category_id'],
				'prod_name'		=>$field['prod_name'],
				'kh_prod_name'	=>$field['kh_prod_name'],
				'prod_alias'	=>$field['prod_alias'],
				'prod_mate_code'=>$field['prod_mate_code'],
				'prod_size'		=>$field['prod_size'],
				'kh_prod_size'	=>$field['kh_prod_size'],
				'prod_deal'		=>$field['prod_deal'],
		);
		$sql = new Sql($this->adapter);
		$insert = $sql->insert('products')->values($values);
		$sql->prepareStatementForSqlObject($insert)->execute();
		
		//save to image table default image
		$productId = $this->adapter->driver->getLastGeneratedValue();
		$insert = $sql->insert('images')->values(array('product_id'=>$productId,'imag_name'=>$field['imag_name'], 'imag_status'=>1));
		$sql->prepareStatementForSqlObject($insert)->execute();
		
	}
	
	//get product by id
	public function getProductById($Id)
	{
		$sql = new Sql($this->adapter);
		$object = $sql->select('products')->where("product_id=$Id");
		$statement = $sql->prepareStatementForSqlObject($object)->execute();
	
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer();
	
	}
	
	//edit product by id
	public function editProductById($f, $Id)
	{
		if(!empty($Id))
		{
			$values = array(
					//'category_id'	=>$f['category_id'],
					'prod_name'		=>$f['prod_name'],
					'kh_prod_name'	=>$f['kh_prod_name'],
					'prod_alias'	=>$f['prod_alias'],
					'prod_mate_code'=>$f['prod_mate_code'],
					'prod_size'		=>$f['prod_size'],
					'kh_prod_size'	=>$f['kh_prod_size'],
					'prod_deal'		=>$f['prod_deal']
			);
			$sql = new Sql($this->adapter);
			$update = $sql->update('products')->set($values)->where("product_id=$Id");
			$sql->prepareStatementForSqlObject($update)->execute();
			
		}
		
	}
	
	
	//delete product by id
	public function deleteProductById($Id)
	{
		if(!empty($Id))
		{
			$sql = new Sql($this->adapter);
			$delete = $sql->delete('products')->where("product_id=$Id");
			$sql->prepareStatementForSqlObject($delete)->execute();
			
			$delete = $sql->delete('images')->where("product_id=$Id");
			$sql->prepareStatementForSqlObject($delete)->execute();
		}
	}
	
	//save image medias
	public function savemedia($data)
	{
		$values = array(
				'product_id'	=> $data['product_id'],
				'imag_name'		=> $data['imag_name'],
				'imag_size'		=> $data['imag_size'],
				'imag_status'	=> $data['imag_status']
		);
		$sql = new Sql($this->adapter);
		$insert = $sql->insert('images')->values($values);
		$sql->prepareStatementForSqlObject($insert)->execute();
	}
	
	//get image
	public function getImage()
	{
		$sql = new Sql($this->adapter);
		$select = $sql->select('images')->order("image_id DESC");
		$statement = $sql->prepareStatementForSqlObject($select)->execute();
		
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	}
	
	//remove image or meida by id
	public function removeMediaById($id)
	{
		if(!empty($id))
		{
			$sql = new Sql($this->adapter);
			$delete = $sql->delete('images')->where("image_id = $id");
			$sql->prepareStatementForSqlObject($delete)->execute();
		}
	}
	
	//get media image by id
	public function getMediaById($id)
	{
		if(!empty($id))
		{
			$sql = new Sql($this->adapter);
			$select = $sql->select('images')->where("image_id = $id");
			$st = $sql->prepareStatementForSqlObject($select)->execute();
			
			$rs = new ResultSet();
			return $rs->initialize($st)->buffer()->toArray();
		}
	}
	
	//update media
	public function updateMedia($id, $f)
	{
		if(!empty($id))
		{
			$data = array(
				'imag_size'=>$f['imag_size'], 'imag_status'=>$f['imag_status']
			);
			$sql = new Sql($this->adapter);
			$update = $sql->update('images')->set($data)->where("image_id = $id");
			$sql->prepareStatementForSqlObject($update)->execute();
		}
	}
	
	//get info
	
	public function getInfo()
	{
		$sql = new Sql($this->adapter);
		$select = $sql->select('information')->order("information_id DESC");
		$st = $sql->prepareStatementForSqlObject($select)->execute();
			
		$rs = new ResultSet();
		return $rs->initialize($st)->buffer()->toArray();
	}
	
	//save new info
	public function saveInfo($file)
	{
		$files = array (
				'category_id' => $file ['category_id'],
				'info_desc' => $file ['info_desc'],
				'kh_info_desc'=>$file['kh_info_desc'],

				'info_gene' => $file ['info_gene'],
				'kh_info_gene'=>$file['kh_info_gene'],

				'info_color' => $file ['info_color'],
				'kh_info_color'=>$file['kh_info_color'],
		);
		
		if (! empty ( $files )) {
			$sql = new Sql ( $this->adapter );
			$insert = $sql->insert ( 'information' )->values ( $files );
			return $sql->prepareStatementForSqlObject ( $insert )->execute ();
		}
	}
	
	//get info by id
	public function getInfoById($id)
	{
		if(!empty($id))
		{
			$sql = new Sql($this->adapter);
			$select = $sql->select('information')->where("information_id =$id");
			$statement = $sql->prepareStatementForSqlObject($select)->execute();
			
			$rs = new ResultSet();
			return $rs->initialize($statement)->buffer();
		}
	}
	
	//save new info
	public function updateInfo($file, $id)
	{
		$files = array (
				'category_id' => $file ['category_id'],
				'info_desc' => $file ['info_desc'],
				'kh_info_desc'=>$file['kh_info_desc'],
	
				'info_gene' => $file ['info_gene'],
				'kh_info_gene'=>$file['kh_info_gene'],
	
				'info_color' => $file ['info_color'],
				'kh_info_color'=>$file['kh_info_color'],
		);
	
		if (! empty ( $files )) {
			$sql = new Sql ( $this->adapter );
			$update = $sql->update ( 'information' )->set ( $files )->where("information_id=$id");
			$sql->prepareStatementForSqlObject ( $update )->execute ();
		}
	}
	
	
	//remove info
	public function removeInfo($id)
	{
		if(!empty($id))
		{
			$sql = new Sql($this->adapter);
			$delete = $sql->delete('information')->where("information_id=$id");
			$sql->prepareStatementForSqlObject($delete)->execute();
		}
	}
	
	//get technical
	public function getTechnical()
	{
		$sql = new Sql($this->adapter);
		$select = $sql->select('technical')->order("technical_id  DESC");
		$statement = $sql->prepareStatementForSqlObject($select)->execute();
		
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	}
	//get standard
	public function getStandard()
	{
		$sql =new Sql($this->adapter);
		$select = $sql->select('standard')->order("standard_id DESC");
		$statement = $sql->prepareStatementForSqlObject($select)->execute();
	
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	}
	// Get Specification
	public function getSpecification()
	{
		$sql=new Sql($this->adapter);
		$select = $sql->select('specification')->order('specification_id DESC');
		$statement = $sql->prepareStatementForSqlObject($select)->execute();
	
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	}
	//save standard
	public function saveStandard($f)
	{

		$sql = new Sql($this->adapter);
		$insert = $sql->insert('standard')->values(array('stan_image'=> $f['stan_image'],'stan_title'=> $f['stan_title'],));
		$sql->prepareStatementForSqlObject($insert)->execute();
		
		$standId = $this->adapter->driver->getLastGeneratedValue();
		$insert = $sql->insert('categories_standard')->values(array('category_id'=> $f['category_id'],'standard_id'=> $standId));
		$sql->prepareStatementForSqlObject($insert)->execute();
		
		
	}
	
	//save cate id to remove standrad
	public function removeStandard($id)
	{
		
		$sql = new Sql($this->adapter);
		$delete = $sql->delete('standard')->where("standard_id = $id");
		$sql->prepareStatementForSqlObject($delete)->execute();
		
		$delete = $sql->delete('categories_standard')->where("standard_id = $id");
		$sql->prepareStatementForSqlObject($delete)->execute();
	}
	
	//update standard
	public function updateStandard($f, $id)
	{
		$sql =new Sql($this->adapter);
		$update = $sql->update('standard')->set(array('stan_title'=>$f['stan_title']))->where("standard_id=$id");
		$sql->prepareStatementForSqlObject($update)->execute();	
	}
	
	//get image by id
	public function getImageById($id)
	{
		if(!empty($id))
		{
			$sql = new Sql($this->adapter);
			$select = $sql->select('images')->where("product_id=$id")->order("imag_name DESC");
			$statement = $sql->prepareStatementForSqlObject($select)->execute();
			
			$rs = new ResultSet();
			return $rs->initialize($statement)->buffer()->toArray();
		}
	}
	// save Specification
	public function saveSpecification($f)
	{
		// insert to table specification
		$sql = new Sql($this->adapter);
		$insert = $sql->insert('specification')->values(array('spec_image'=>$f['spec_image'],'spec_title'=>$f['spec_title'],'kh_spec_title'=>$f['kh_spec_title']));
		$sql->prepareStatementForSqlObject($insert)->execute();
	
		// insert to table category_specification
		$specification_id = $this->adapter->driver->getLastGeneratedValue();
		$insert = $sql->insert('categories_specification')->values(array('category_id'=>$f['category_id'],'specification_id'=>$specification_id));
		$sql->prepareStatementForSqlObject($insert)->execute();
	}
	
	// remove Specification
	public function  removeSpecification($id)
	{
		// delete from specification
		$sql = new Sql($this->adapter);
		$delete = $sql ->delete('specification')->where("specification_id = $id");
		$sql->prepareStatementForSqlObject($delete)->execute();
	
		// delete from categories_specification
		$delete = $sql->delete('categories_specification')->where("specification_id = $id");
		$sql ->prepareStatementForSqlObject($delete)->execute();
	}
	
	// updat specification
	public function updateSpecification($field,$spec_id)
	{
		$sql = new Sql($this->adapter);
		$update = $sql->update('specification')->set(array('spec_title'=>$field['spec_title'],'kh_spec_title'=>$field['kh_spec_title']))->where("specification_id = $spec_id");
		$sql->prepareStatementForSqlObject($update)->execute();
	}
	
	// Check image specification in folder
	public function checkExistImageSpecification($spec_id)
	{
		if(!empty($spec_id))
		{
			$sql = new Sql($this->adapter);
			$se = $sql->select('specification')->where("specification_id = $spec_id");
			$st = $sql->prepareStatementForSqlObject($se)->execute();
				
			$rs = new ResultSet();
			return $rs->initialize($st)->buffer()->toArray();
		}
	}
	
	//get technical
	public function getTechnicalById($id)
	{
		if(!empty($id))
		{
			$sql = new Sql($this->adapter);
			$select = $sql->select('technical')->where("technical_id= $id");
			$statement = $sql->prepareStatementForSqlObject($select)->execute();
			
			$rs = new ResultSet();
			return $rs->initialize($statement)->buffer();
		}
	}
	
	//save standard
	public function updateTechnical($f, $id)
	{
		if(!empty($id))
		{
			$data = array(
					//'category_id'=>$f['category_id'],
					'tech_field'=>$f['tech_field'],
					'kh_tech_field'=>$f['kh_tech_field'],
					'tech_value'=>$f['tech_value'],
					'kh_tech_value'=>$f['kh_tech_value'],
			);
			$sql = new Sql($this->adapter);
			$update = $sql->update('technical')->set($data)->where("technical_id=$id");
			$sql->prepareStatementForSqlObject($update)->execute();
		}
	}
	
	//remove technical
	public function removeTechnical($id)
	{
		if(!empty($id))
		{
			$sql = new Sql($this->adapter);
			$delete = $sql->delete('technical')->where("technical_id=$id");
			$sql->prepareStatementForSqlObject($delete)->execute();
		}
	}
	
	
	//save technical
	public function saveTechnical($f)
	{
		$data = array(
				'category_id'=>$f['category_id'],
				'tech_field'=>$f['tech_field'],
				'kh_tech_field'=>$f['kh_tech_field'],
				'tech_value'=>$f['tech_value'],
				'kh_tech_value'=>$f['kh_tech_value'],					
		);
		$sql = new Sql($this->adapter);
		$insert = $sql->insert('technical')->values($data);
		$sql->prepareStatementForSqlObject($insert)->execute();
	
	}
	
	// remove parent beyond living
	public function removeParent($parentId)
	{
		$sql = new Sql($this->adapter);
		$delete = $sql->delete('living')->where("living_id=$parentId");
		$sql->prepareStatementForSqlObject($delete)->execute();
	}
	
	// update parent beyond living
	public function updateParent($data,$parentId)
	{
		$sql = new Sql($this->adapter);
		$update = $sql->update('living')->set($data)->where("living_id =$parentId");
		$sql->prepareStatementForSqlObject($update)->execute();
	}
	
	// get tools
	public function getTool()
	{
		$sql = new Sql($this->adapter);
		$select = $sql->select('tools');
		$statement = $sql->prepareStatementForSqlObject($select)->execute();
		
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	}
	
	// save tools
	public function saveTool($field)
	{
		$sql = new Sql($this->adapter);
		$insert = $sql->insert('tools')->values($field);
		$sql->prepareStatementForSqlObject($insert)->execute();	
	}
	
	// remove tools
	public function removeTool($tool_id)
	{
		$sql =new Sql($this->adapter);
		$delete = $sql->delete('tools')->where("tool_id=$tool_id");
		$sql->prepareStatementForSqlObject($delete)->execute();
	}
	
	// update tools
	public function updateTool($field,$tool_id)
	{
		$sql = new Sql($this->adapter);
		$update = $sql->update('tools')->set($field)->where("tool_id=$tool_id");
		$sql->prepareStatementForSqlObject($update)->execute();
	}
	
	//upload new slide to database
	public  function uploadSlide($f)
	{
		$data = array(
			'slid_control' => $f['slid_control'],
			'slid_title'	=> $f['slid_title'],
			'kh_slid_title'	=> $f['kh_slid_title'],
			'slid_image'	=> $f['slid_image'],
			'slid_order'	=> $f['slid_order'],
			'slid_desc'		=> $f['slid_desc'],
			'kh_slid_desc'		=> $f['kh_slid_desc'],
		);
		
		$sql = new Sql($this->adapter);
		$insert = $sql->insert('slide')->values($data);
		$sql->prepareStatementForSqlObject($insert)->execute();
	}
	
	// get tools
	public function getSlide() //admin
	{
		$sql = new Sql($this->adapter);
		$select = $sql->select('slide')->order("slide_id DESC");
		$statement = $sql->prepareStatementForSqlObject($select)->execute();
	
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	}
	
	
	//remove slide 
	public function removeSlide($id)
	{
		if(!empty($id))
		{
			$sql = new Sql($this->adapter);
			$delete = $sql->delete('slide')->where("slide_id=$id");
			$sql->prepareStatementForSqlObject($delete)->execute();
		}
	}
	
	// check slide by id
	public function checkSlide($Id) {
		if (! empty ( $Id )) {
			$sql = new Sql ( $this->adapter );
			$se = $sql->select ( 'slide' )->where ( "slide_id= $Id" );
			$st = $sql->prepareStatementForSqlObject ( $se )->execute ();
				
			$rs = new ResultSet ();
			return $rs->initialize ( $st )->buffer ()->toArray ();
		}
	}
	
	//get slide by id
	
	public function getSlideById($id)
	{
		if(!empty($id))
		{
			$sql = new Sql($this->adapter);
			$select = $sql->select('slide')->where("slide_id=$id");
			$statment = $sql->prepareStatementForSqlObject($select)->execute();
			
			$rs = new ResultSet();
			return $rs->initialize($statment)->buffer();
		}
	}
	
	//update slide by id
	public function updateSlideById($d, $id)
	{
		if(!empty($id))
		{
			$data = array (
					'slid_control' => $d['slid_control'],
					'slid_title' => $d['slid_title'],
					'kh_slid_title' => $d['kh_slid_title'],
					'slid_order' => $d['slid_order'],
					'slid_desc'		=>$d['slid_desc'],
					'kh_slid_desc'		=>$d['kh_slid_desc'],
						
			);
			
			$sql = new Sql($this->adapter);
			$update = $sql->update("slide")->set($data)->where("slide_id=$id");
			$sql->prepareStatementForSqlObject($update)->execute();
		}
	}
	
	//get slide by controller name
	public function getSlideByController($name)
	{
		if(!empty($name))
		{
			$sql = new Sql($this->adapter);
			$select = $sql->select("slide")->where("slid_control='$name'")->order("slid_order ASC");
			$statement = $sql->prepareStatementForSqlObject($select)->execute();
			$rs = new ResultSet();
			return $rs->initialize($statement)->buffer()->toArray();
		}
	}
	
	//get filter slide by control name
	public function getFilterSlide($name)
	{
		if(!empty($name))
		{
			$sql  = new Sql($this->adapter);
			$filter = $sql->select("slide")->where("slid_control = '$name'")->order("slid_order DESC");
			$statment = $sql->prepareStatementForSqlObject($filter)->execute();
			
			$rs = new ResultSet();
			return $rs->initialize($statment)->buffer()->toArray();
		}
	}
	//get cate by id
	public function getCateByFilter($filter)
	{
		if(!empty($filter))
		{
			$sql = new Sql($this->adapter);
			$select = $sql->select('categories')->where("cate_parent = $filter");
			$st = $sql->prepareStatementForSqlObject($select)->execute();
			$rs  = new ResultSet();
			return $rs->initialize($st)->buffer()->toArray();
		}
	}
	
	//get product by filter
	public function getProductByFilter($filter)
	{
		if(!empty($filter))
		{
			$sql= new Sql($this->adapter);
			$select = $sql->select('products')->where("category_id=$filter");
			$st = $sql->prepareStatementForSqlObject($select)->execute();
			$rs = new ResultSet();
			return $rs->initialize($st)->buffer()->toArray();
		}
	}
	// filter specification 
	public function getFilterSpecification($catId)
	{
		$sql = new Sql($this->adapter);
		$select = $sql->select(array('s'=>'specification'))
			   	->join(array('c'=>'categories_specification'),'s.specification_id=c.specification_id')
			   ->where("c.category_id=$catId");
	
		$statement = $sql->prepareStatementForSqlObject($select)->execute();
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	}
	
	// filter standard
	public function getFilterStandard($catId)
	{
		$sql = new Sql($this->adapter);
		$select = $sql->select(array('s' =>'standard'))
					  ->join(array('c' =>'categories_standard'), 's.standard_id=c.standard_id')
					  ->where("c.category_id=$catId");
		$statement = $sql->prepareStatementForSqlObject($select)->execute();
		
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	}
	//get information by filter
	public function getInfoByFilter($filter)
	{
		if(!empty($filter))
		{
			$sql = new Sql($this->adapter);
			$s = $sql->select('information')->where("category_id=$filter");
			$st = $sql->prepareStatementForSqlObject($s)->execute();
				
			$rs = new ResultSet();
			return $rs->initialize($st)->buffer()->toArray();
		}
	}
	// filter technical 
	public function getFilterTechnical($catId)
	{
		$sql = new Sql($this->adapter);
		$select = $sql->select('technical')->where("category_id=$catId");
		$statement = $sql->prepareStatementForSqlObject($select)->execute();
		
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	}
	
	// add spec to cat
	public function addspecTocat($specId,$catId)
	{
		$sql = new Sql($this->adapter);
		$insert = $sql->insert('categories_specification')->values(array('category_id'=>$catId,'specification_id'=>$specId));
		$sql->prepareStatementForSqlObject($insert)->execute();
	}
	//save standard add to other cate
	public function saveStandardAddTo($f)
	{
		if(!empty($f))
		{
			$v = array('category_id'=> $f['category_id'], 'standard_id'=>$f['standard_id']);
			$sql = new Sql($this->adapter);
			$save  = $sql->insert("categories_standard")->values($v);
			$sql->prepareStatementForSqlObject($save)->execute();
		}
	}
	// check spec in category
	public function checkSpecincategory($specId,$catId){
		$sql = new Sql($this->adapter);
		$select = $sql->select('categories_specification')->where("category_id=$catId AND specification_id=$specId");
		$statement = $sql->prepareStatementForSqlObject($select)->execute();
		
		$rs = new ResultSet();
		return $rs->initialize($statement)->buffer()->toArray();
	}
    public function ZF2_Query($sqlString)
    {
        /*~~~~~~~ Create Proceduter in db: query_data(IN myquery varchar(500) ~~~
            BEGIN
                #Routine body goes here...
                SET @mysql = myquery;
                PREPARE stm from @mysql;
                EXECUTE stm;
            END
        /~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
        $driver = $this->adapter->getDriver();
        $connection = $driver->getConnection();

        $result = $connection->execute("CALL query_data('$sqlString')");
        $statement = $result->getResource();
        $data =  $statement->fetchAll();
        return $data;
    }
    // Function Name : ZF2_Update($table,$values,$conditions) -> user to update data table
    // Developer Name : PON NIMOL
    // Date : 03/ July / 2014
    // param 1: $table is the name of table
    // param 2: $values  is data array to update
    // param 3: $conditons is data array to update by condition
    public function ZF2_Update($table,$values,$conditions)
    {
        $sql = new Sql($this->adapter);
        $update = $sql->update($table)->set($values)->where($conditions);
        return $sql->prepareStatementForSqlObject($update)->execute();
    }
    // Function Name : ZF2_Insert($table,$values) -> use to insert data to table
    // Developer Name : PON NIMOL
    // Date : 03/ July / 2014
    // param 1: $table is the name of table
    // param 2: $values  is data array that will insert to table
    public function ZF2_Insert($table,$values)
    {
        $sql = new Sql($this->adapter);
        $insert = $sql->insert($table)->values($values);
        return $sql->prepareStatementForSqlObject($insert)->execute();
    }
    // Function Name : ZF2_Delete($table,$values) -> use to delete data from table
    // Developer Name : PON NIMOL
    // Date : 08/ July / 2014
    // param 1: $table is the name of table
    // param 2: $condition  is data array that will input to WHERE statement
    public function ZF2_Delete($table,$conditions)
    {
        $sql = new Sql($this->adapter);
        $delete = $sql->delete($table)->where($conditions);
        return $sql->prepareStatementForSqlObject($delete)->execute();
    }
    // Function Name : ZF2_Select_AllColumn($table) -> use to all column from table
    // Developer Name : PON NIMOL
    // Date : 17/ July / 2014
    // param 1: $table is the name of table
    // param 2: $condition  is data array that will input to WHERE statement
    public function ZF2_Select_AllColumn($table,$conditions=array())
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select($table)->where($conditions);
        $stm = $sql->prepareStatementForSqlObject($select)->execute();
        $rs = new ResultSet();
        return $rs->initialize($stm)->buffer()->toArray();
    }
    // Function Name : ZF2_Select($table) -> use to get data table
    // Developer Name : PON NIMOL
    // Date : 24/ July / 2014
    // param 1: $table is the name of table
    public function ZF2_Select($table,$conditions=array())
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select($table)->where($conditions);;
        $stm = $sql->prepareStatementForSqlObject($select)->execute();
        $rs = new ResultSet();
        return $rs->initialize($stm)->buffer()->toArray();
    }
}