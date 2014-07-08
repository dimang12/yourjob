<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\CateForm;
use Zend\Validator\File\Size;
use Production\Model\ProductTable;
class CategoryController extends AbstractActionController {
	public function indexAction() {
		$sm = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
		$getCate = $sm->getCate ();
		$form = new CateForm();
		$sm = $this->serviceLocator->get ('Production\Model\ProductTable' );
		$option = $sm->getCateZeroCount();
		return array (
				'getCate' => $getCate, 'form'=>$form,'option'=>$option
		);
	}
	public function newcateAction() {
		$message = ''; // defaule error message
		$form = new CateForm ();
		$cateName = $this->params ()->fromPost ( 'cate_name' );
		$cateAlias = strtolower ( preg_replace ( "![^a-z0-9]+!i", "-", $cateName ) );
		$khCateName = $this->params ()->fromPost ( 'kh_cate_name' );
		$cateOrder = $this->params ()->fromPost ( 'cate_order' );
		$cateDetails = $this->params ()->fromPost ( 'cate_details' );
		$khCateDetails = $this->params ()->fromPost ( 'kh_cate_details' );
		$cateImage = $this->params ()->fromFiles ( 'cate_image' );
		
		$sm = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
		$image = $cateImage['name'];
		
		if ($this->getRequest ()->isPost ()) {
				$ext = pathinfo ( $image, PATHINFO_EXTENSION );
				$image = uniqid(). '.' . $ext;
				
				//set new values into database
				$data = array (
						'cate_parent' => 0, // parent value
						'cate_name' => $cateName,
						'cate_alias' => $cateAlias,
						'kh_cate_name' => $khCateName,
						'cate_order' => $cateOrder,
						'cate_details' => $cateDetails,
						'kh_cate_details' => $khCateDetails,
						'cate_image' => $image
				);
				$size = new Size ( array ('max' => 1048576) ); // 1mb
				$adapter = new \Zend\File\Transfer\Adapter\Http ();
				$adapter->setValidators ( array ($size), $image );
				$sm->saveCate($data );
				
				// save to folders upload
				$dir = 'public/img/uploads';
				if (file_exists ( $dir )) {
					move_uploaded_file ( $cateImage ['tmp_name'], $dir . '/' . $image );
				}
				return $this->redirect()->toUrl('dashboard-category');
			
		}
		return array (
				'form' => $form,
				'message' => $message 
		);
	}
	
	// edit cate
	public function editcateAction() {
		$form = new CateForm ();
		$cateId = $this->params ()->fromQuery ( 'cateId' );
		$sm = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
		$getCateById = $sm->getCateById ( $cateId )->current ();
		$getImage = $getCateById ['cate_image'];
		$form->bind ( $getCateById );
		
		$cateName = $this->params ()->fromPost ( 'cate_name' );
		$cateAlias = strtolower ( preg_replace ( "![^a-z0-9]+!i", "-", $cateName ) );
		$khCateName = $this->params ()->fromPost ( 'kh_cate_name' );
		$cateOrder = $this->params ()->fromPost ( 'cate_order' );
		$cateDetails = $this->params ()->fromPost ( 'cate_details' );
		$khCateDetails = $this->params ()->fromPost ( 'kh_cate_details' );
		$cateImage = $this->params ()->fromFiles ( 'cate_image' );
		
		$image = $cateImage ['name']; $local = ''; //default loca
		if($this->getRequest()->isPost())
		{
			if(!empty($image))
			{
				$local = "public/img/uploads/$getImage";
				if(file_exists($local)) 
				{
					unlink($local);
				}
				
				$ext = pathinfo ( $image, PATHINFO_EXTENSION );
				$image = uniqid(). '.' . $ext;
				
				//set new values into database
				$data = array (
						'cate_parent' => 0, // parent value
						'cate_name' => $cateName,
						'cate_alias' => $cateAlias,
						'kh_cate_name' => $khCateName,
						'cate_order' => $cateOrder,
						'cate_details' => $cateDetails,
						'kh_cate_details' => $khCateDetails,
						'cate_image' => $image
				);
				$size = new Size ( array ('max' => 1048576) ); // 1mb
				$adapter = new \Zend\File\Transfer\Adapter\Http ();
				$adapter->setValidators ( array ($size), $image );
				$sm->updateCate ( $cateId, $data );
				
				// save to folders upload
				$dir = 'public/img/uploads';
				if (file_exists ( $dir )) {
					move_uploaded_file ( $cateImage ['tmp_name'], $dir . '/' . $image );
				}
				return $this->redirect()->toUrl('dashboard-category');
			
			}else{
				$data = array (
					'cate_parent' => 0, // parent value
					'cate_name' => $cateName,
					'cate_alias' => $cateAlias,
					'kh_cate_name' => $khCateName,
					'cate_order' => $cateOrder,
					'cate_details' => $cateDetails,
					'kh_cate_details' => $khCateDetails,
				);
				$sm->updateCateNoImage($cateId, $data);
				return $this->redirect()->toUrl('dashboard-category');
			}
		}
		return array('form'=>$form, 'getImage'=>$getImage);
	}	

	//delete cate
	public function deletecateAction()
	{
		$this->layout('layout/_ajax_layout');
		$sm = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
		$id = $this->params()->fromQuery('id');
		$sm->deleteCate($id);
		return false;
	}
	
	//create sub cate
	public function createsubcateAction()
	{
		$form = new CateForm();
		$sm = $this->serviceLocator->get ('Production\Model\ProductTable' );
		$service = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
			
		$option = $sm->getCateZeroCount();
		$parentId = $this->params()->fromPost('cate_parent');
		$cateName = $this->params ()->fromPost ( 'cate_name' );
		$cateAlias = strtolower ( preg_replace ( "![^a-z0-9]+!i", "-", $cateName ) );
		$khCateName = $this->params ()->fromPost ( 'kh_cate_name' );
		$cateOrder = $this->params ()->fromPost ( 'cate_order' );
		$cateDetails = $this->params ()->fromPost ( 'cate_details' );
		$khCateDetails = $this->params ()->fromPost ( 'kh_cate_details' );
			
		$data = array (
				'cate_parent' => $parentId,
				'cate_name' => $cateName,
				'cate_alias' => $cateAlias,
				'kh_cate_name' => $khCateName,
				'cate_order' => $cateOrder,
				'cate_details' => $cateDetails,
				'kh_cate_details' => $khCateDetails,
		);
		
		if($this->getRequest()->isPost())
		{
			$service->saveSubCate($data);
			return $this->redirect ()->toUrl ( 'dashboard-category' );
		}
		return array('form'=>$form, 'option'=>$option);
	}
	
	//edit sub cate
	public function editsubcateAction()
	{
		
		$form = new CateForm();
		$cateId = $this->params()->fromQuery('cateId');
		$sm = $this->serviceLocator->get ('Production\Model\ProductTable' );
		$service = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
		$getCateById = $service->getCateById($cateId)->current();
		$form->bind($getCateById);
		$option = $sm->getCateZeroCount();
		$parentId = $this->params()->fromPost('cate_parent');
		$cateName = $this->params ()->fromPost ( 'cate_name' );
		$cateAlias = strtolower ( preg_replace ( "![^a-z0-9]+!i", "-", $cateName ) );
		$khCateName = $this->params ()->fromPost ( 'kh_cate_name' );
		$cateOrder = $this->params ()->fromPost ( 'cate_order' );
		$cateDetails = $this->params ()->fromPost ( 'cate_details' );
		$khCateDetails = $this->params ()->fromPost ( 'kh_cate_details' );
			
		$data = array (
				'cate_parent' => $parentId,
				'cate_name' => $cateName,
				'cate_alias' => $cateAlias,
				'kh_cate_name' => $khCateName,
				'cate_order' => $cateOrder,
				'cate_details' => $cateDetails,
				'kh_cate_details' => $khCateDetails,
		);
		
		if($this->getRequest()->isPost())
		{
			$service->editSubCate($data, $cateId);
			return $this->redirect ()->toUrl ( 'dashboard-category' );
		}
		return array('form'=>$form, 'option'=>$option);
	}
	
	//filter cate by id
	public function catefilterAction()
	{
		$this->layout('layout/_ajax_layout');
		$id = $this->params()->fromQuery('id');
		$service = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
		$getCateById = $service->getCateByFilter($id);
		return array('getCate'=>$getCateById);
	}
}





















