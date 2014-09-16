<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\CateForm;
use Zend\Validator\File\Size;
use Production\Model\ProductTable;
class CategoryController extends AbstractActionController {
	public function indexAction() {
		$sm = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
		$catData = $sm->ZF2_Select('categories');

        $page = $this->params()->fromQuery('page');
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($catData));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(4);
		return array (
				'catData' => $paginator
		);
	}
	public function newcateAction() {
		$form = new CateForm ();
		$cateName = $this->params ()->fromPost ( 'cate_name' );
		//$cateAlias = strtolower ( preg_replace ( "![^a-z0-9]+!i", "-", $cateName ) );
		$cateOrder = $this->params ()->fromPost ( 'cate_order' );
		$cateDetails = $this->params ()->fromPost ( 'cate_details' );
		$sm = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
		if ($this->getRequest ()->isPost ()) {
				$values = array (
						'cate_name' => $cateName,
						'cate_order' => $cateOrder,
						'cate_details' => $cateDetails,
				);
				$sm->ZF2_Insert('categories',$values);
				return $this->redirect()->toUrl('dashboard-category');
		}
		return array (
				'form' => $form,
		);
	}
	
	// edit cate
	public function editcateAction() {
		$form = new CateForm ();
		$cateId = $this->params ()->fromQuery ( 'catId' );
		$sm = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
		if($this->getRequest()->isPost())
		{
            $cateName = $this->params ()->fromPost ( 'cate_name' );
            $cateOrder = $this->params ()->fromPost ( 'cate_order' );
            $cateDetails = $this->params ()->fromPost ( 'cate_details' );
            $values = array (
                'cate_name' => $cateName,
                'cate_order' => $cateOrder,
                'cate_details' => $cateDetails,
            );
            $sm->ZF2_Update('categories',$values,array('category_id'=>$cateId));
            return $this->redirect()->toUrl('dashboard-category');
		}
        $catData = $sm->ZF2_Select_AllColumn('categories',array('category_id'=>$cateId));
		return array('form'=>$form,'catData'=>$catData);
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





















