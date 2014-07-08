<?php 
namespace Admin\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Admin\Model\GlobalModel;
use Admin\Form\ProductForm;
use Admin\Form\MediaForm;
use Zend\Validator\File\Size;
use Admin\Form\InformationForm;
use Admin\Form\TechnicalForm;
use Zend\Db\Sql\Sql;
use Admin\Form\StandardForm;
use Admin\Form\SpecificationForm;
use Admin\Form\toolForm;
class ProductionController extends AbstractActionController
{
	public function indexAction()
	{
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$product = $sm->getProduct();	
		
		$cate = $sm->getCate();
		$form = new ProductForm();
		return array(
				'product'=>$product,
				'form'=>$form,
				'option'	=> $cate,
		);
	}
	
	//add new products
	public function addAction()
	{
		$form = new ProductForm();
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$cate = $sm->getCate();
		$cateId= $this->params()->fromPost('category_id');
		$prodName= $this->params()->fromPost('prod_name');
		$kh_prodName = $this->params()->fromPost('kh_prod_name');
		$prodAlias = strtolower ( preg_replace ( "![^a-z0-9]+!i", "-", $prodName ) );
		$prodMateCode = $this->params()->fromPost('prod_mate_code');
		$prodSize = $this->params()->fromPost('prod_size');
		$kh_prodSize = $this->params()->fromPost('kh_prod_size');
		$prodDeal =  $this->params()->fromPost('prod_deal');
		
		$file = $this->params()->fromFiles('imag_name');
		$image = $file['name'];
		if($this->getRequest()->isPost())
		{
			if(!empty($image))
			{
				$image = $file ['name'];
				$ext = pathinfo ( $image, PATHINFO_EXTENSION );
				$image = uniqid () . '.' . $ext;
				
				$field = array(
						'category_id'	=>$cateId,
						'prod_name'		=>$prodName,
						'kh_prod_name'	=>$kh_prodName,
						'prod_alias'	=>$prodAlias,
						'prod_mate_code'=>$prodMateCode,
						'prod_size'		=>$prodSize,
						'kh_prod_size'	=>$kh_prodSize,
						'prod_deal'		=>$prodDeal,
						'imag_name'		=> $image,	
				);
			}
			
			$size = new Size(array('max'=>1048576)); //1MB
			$adapter = new \Zend\File\Transfer\Adapter\Http();
			$adapter->setValidators(array($size), $image);
			
			if(! $adapter->isValid())
			{
				$message = 'Max size: 1MB';
			}else{
				
				//save to product table
				$sm->saveproduct($field);
				$sizes = array(80 => 80, 200=>200);
				//store to folder
				$dir = 'public/img/products/l';
				if(file_exists($dir))
				{
					move_uploaded_file($file['tmp_name'], $dir.'/'.$image);
				}
				foreach($sizes as $w => $h){
					$sm->scaleImage($w, $h, $dir, $file['type'], $image);
				}
				return $this->redirect()->toUrl('dashboard-production');
			}			
		}
		return array('form'=>$form,'option'=>$cate);
	}

	//edit products
	public function editAction()
	{
		
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$form = new ProductForm();
		$cate = $sm->getCate();
		$prodId = $this->params()->fromQuery('prodId');
		$getProductById = $sm->getProductById($prodId)->current();
		$form->bind($getProductById);
		
		if($this->getRequest()->isPost())
		{
			//$cateId= $this->params()->fromPost('category_id');
			$prodName= $this->params()->fromPost('prod_name');
			$kh_prodName = $this->params()->fromPost('kh_prod_name');
			$prodAlias = strtolower ( preg_replace ( "![^a-z0-9]+!i", "-", $prodName ) );
			$prodMateCode = $this->params()->fromPost('prod_mate_code');
			$prodSize = $this->params()->fromPost('prod_size');
			$kh_prodSize = $this->params()->fromPost('kh_prod_size');
			$prodDeal =  $this->params()->fromPost('prod_deal');
				
			$field = array(
					//'category_id'	=>$cateId,
					'prod_name'		=>$prodName,
					'kh_prod_name'	=>$kh_prodName,
					'prod_alias'	=>$prodAlias,
					'prod_mate_code'=>$prodMateCode,
					'prod_size'		=>$prodSize,
					'kh_prod_size'	=>$kh_prodSize,
					'prod_deal'		=>$prodDeal
			);
			if(!empty($field))
			{
				$sm->editProductById($field, $prodId);
				
				return $this->redirect()->toUrl('dashboard-production');
			}
		}
		
		return array(
				'form'=>$form,
				'option'=>$cate,
				'media'=>'Media'
		);
	}
	
	//delete product by id using ajax
	public function deleteproductAction()
	{
		$this->layout('layout/_ajax_layout');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$Id = $this->params()->fromQuery('Id');
		$sm->deleteProductById($Id);
		return false;
	}
	
	//product media
	public function mediaAction()
	{
		$prodId = $this->params()->fromQuery('prodId');
		$message = '';
		$form = new MediaForm();
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		//$product = $sm->getProduct();
		
		if($this->getRequest()->isPost())
		{
			//$prodId = $this->params()->fromPost('product_id');
			$file = $this->params()->fromFiles('imag_name');
			$imgName = $file['name'];
			$ext = pathinfo($imgName, PATHINFO_EXTENSION);			
			$name = uniqid(). '.' . $ext;
			//$imgName = strtolower ( preg_replace ( "![^a-z0-9]+!i", "-", $imgName ) );
			$imgSize = $this->params()->fromPost('imag_size');
			$type = $file['type'];
			$imgStatus = $this->params()->fromPost('imag_status');
			$field = array(
				'product_id'	=> $prodId,
				'imag_name'		=> $name,
				'imag_size'		=> $imgSize,
				'imag_status'	=> $imgStatus
			);
			$size = new Size(array('max'=>1048576));
			$adapter = new \Zend\File\Transfer\Adapter\Http();
			$adapter->setValidators(array($size), $name);
			
			if(! $adapter->isValid())
			{
				$message = 'Max size: 1MB';
			}else{
				$sm->savemedia($field);
				$sizes = array(80 => 80, 200=>200);
				//store to folder
				$dir = 'public/img/products/l';
				if(file_exists($dir))
				{
					move_uploaded_file($file['tmp_name'], $dir.'/'.$name);
				}
				foreach($sizes as $w => $h){
					$sm->scaleImage($w, $h, $dir, $type, $name);
				}
			}
		}
		//$getImage = $sm->getImage();
		$getImageById = $sm->getImageById($prodId);
		return array(
				'form'=>$form,
				//'option'=>$product,
				'message'=>$message,
				'image' => $getImageById,
				'media'=>'Media'
		);
	}
	
	//remove media by id
	public function mediaremoveAction()
	{
		$this->layout('layout/_ajax_layout');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$id = $this->params()->fromQuery('Id');
		$getMediaById = $sm->getMediaById($id);
		
		$img = $getMediaById[0]['imag_name'];
		$dir = 'public/img/products/l'.$img;
		unlink($dir);
		
		$dir = 'public/img/products/m'.$img;
		unlink($dir);
		
		$dir = 'public/img/products/s'.$img;
		unlink($dir);
		
		$sm->removeMediaById($id);
		return false;
	}
	
	//update media
	public function mediaupdateAction()
	{
		$this->layout('layout/_ajax_layout');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$Id = $this->params()->fromQuery('id');
		$size = $this->params()->fromQuery('size');
		$status = $this->params()->fromQuery('status');
		
		$data  = array('imag_size'=>$size,'imag_status'=>$status);
		$sm->updateMedia($Id, $data);
		return false;
	}
	
	//information
	public function informationAction()
	{
		
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$info = $sm->getInfo();
		$form = new ProductForm();
		$cate = $sm->getCate();
		return array(
				'info'=>$info,
				'form'=>$form,
				'option'=>$cate,
		);
		
	}
	
	//add new info
	public function addinfoAction()
	{
		$form = new InformationForm();
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$cate  = $sm->getCate();
		
		if($this->getRequest()->isPost())
		{
			//get param from form
			$cateId= $this->params()->fromPost('category_id');
			$desc =  $this->params()->fromPost('info_desc');
			$kh_desc =  $this->params()->fromPost('kh_info_desc');
			$gene =  $this->params()->fromPost('info_gene');
			$kh_gene =  $this->params()->fromPost('kh_info_gene');
			$color =  $this->params()->fromPost('info_color');
			$kh_color =  $this->params()->fromPost('kh_info_color');
			
			$data = array(
				'category_id'=>$cateId,
				'info_desc'=>$desc,
				'kh_info_desc'=>$kh_desc,
				'info_gene'=>$gene,
				'kh_info_gene'=>$kh_gene,
				'info_color'=>$color,
				'kh_info_color'=>$kh_color
			);
			
				$sm->saveInfo($data);
				return $this->redirect()->toUrl('dashboard-product-information');
		
		}
		return array(
				'form'=>$form,
				'option'=>$cate
		);
	}
	
	//edit info
	public function editinfoAction()
	{
		$form = new InformationForm();
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$Id = $this->params()->fromQuery('Id');
		$getInfo = $sm->getInfoById($Id)->current();
		$form->bind($getInfo);
		
		if($this->getRequest()->isPost())
		{
			//get param from form
			$cateId= $this->params()->fromPost('category_id');
			$desc =  $this->params()->fromPost('info_desc');
			$kh_desc =  $this->params()->fromPost('kh_info_desc');
			$gene =  $this->params()->fromPost('info_gene');
			$kh_gene =  $this->params()->fromPost('kh_info_gene');
			$color =  $this->params()->fromPost('info_color');
			$kh_color =  $this->params()->fromPost('kh_info_color');
				
			$data = array(
					'category_id'=>$cateId,
					'info_desc'=>$desc,
					'kh_info_desc'=>$kh_desc,
					'info_gene'=>$gene,
					'kh_info_gene'=>$kh_gene,
					'info_color'=>$color,
					'kh_info_color'=>$kh_color
			);
				
			$sm->updateInfo($data, $Id);
			return $this->redirect()->toUrl('dashboard-product-information');
		
		}
		$cate  = $sm->getCate();
		return array(
				'form'=>$form,
				'option'=>$cate
		);
	}
	
	
	//remove information
	public function removeinfoAction()
	{
		$this->layout('layout/_ajax_layout');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$id = $this->params()->fromQuery('id');
		$sm->removeInfo($id);
		return false;
	}
	
	//technical
	public function technicalAction()
	{
		$technicalForm = new TechnicalForm();
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$technical = $sm->getTechnical();
		$cat = $sm->getCate();
		return array(
				'technicals'=>$technical,
				'technicalForm' => $technicalForm,
				'option' =>$cat
		);
	}
	
	//add new technical
	public function addtechnicalAction()
	{
		$form = new TechnicalForm();
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		
		if($this->getRequest()->isPost())
		{
			$cateId = $this->params()->fromPost('category_id');
			$field = $this->params()->fromPost('tech_field');
			$kh_field = $this->params()->fromPost('kh_tech_field');
			$value = $this->params()->fromPost('tech_value');
			$kh_value = $this->params()->fromPost('kh_tech_value');
			
			$data = array(
				'category_id'=>$cateId,
				'tech_field'=>$field,
				'kh_tech_field'=>$kh_field,
				'tech_value'=>$value,
				'kh_tech_value'=>$kh_value,					
			);
			$sm->saveTechnical($data);
			return $this->redirect()->toUrl('dashboard-product-technical');
		}
		
		
		$cate =$sm->getCate();
		return array(
				'form'=>$form,
				'option'=>$cate
		);
	}
	
	//edit technical
	public function edittechnicalAction()
	{
		
		$form = new TechnicalForm();
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$id = $this->params()->fromQuery('Id');
		$technical = $sm->getTechnicalById($id)->current();
		
		if($this->getRequest()->isPost())
		{
			$cateId = $this->params()->fromPost('category_id');
			$field = $this->params()->fromPost('tech_field');
			$kh_field = $this->params()->fromPost('kh_tech_field');
			$value = $this->params()->fromPost('tech_value');
			$kh_value = $this->params()->fromPost('kh_tech_value');
				
			$data = array(
					//'category_id'=>$cateId,
					'tech_field'=>$field,
					'kh_tech_field'=>$kh_field,
					'tech_value'=>$value,
					'kh_tech_value'=>$kh_value,
			);
			$sm->updateTechnical($data, $id);
			return $this->redirect()->toUrl('dashboard-product-technical');
		}
		
		$cate =$sm->getCate();
		$form->bind($technical);
		return array(
				'form'=> $form,
				'option'=>$cate
		);
	}
	
	//remove technical
	public function removeTechnicalAction()
	{
		$this->layout('layout/_ajax_layout');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$id = $this->params()->fromQuery('id');
		$sm->removeTechnical($id);
		return false;
	}
	
	//standard 
	public function standardAction()
	{
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$standard = $sm->getStandard();
		$form = new StandardForm();
		$message = '';
		if($this->getRequest()->isPost())
		{
			$cateId= $this->params()->fromPost('category_id');
			$file = $this->params()->fromFiles('stan_image');
			$stanTitle = $this->params()->fromPost('stan_title');
			$stanImage = strtolower ( preg_replace ( "![^a-z0-9]+!i", "-", $file['name'] ) );
			
			$field = array(	
					'category_id'=>$cateId,				
					'stan_image'		=> $stanImage,
					'stan_title'		=> $stanTitle,
			);
			$size = new Size(array('max'=>1048576));
			$adapter = new \Zend\File\Transfer\Adapter\Http();
			$adapter->setValidators(array($size), $stanImage);
				
			if(! $adapter->isValid())
			{
				$message = 'Max size: 1MB';
			}else{
				$sm->saveStandard($field);
				//store to folder
				$dir = 'public/img/standard';
				if(file_exists($dir))
				{
					move_uploaded_file($file['tmp_name'], $dir.'/'.$stanImage);
				}
				return $this->redirect()->toUrl('dashboard-product-standard');
				
			}
			
			
		}
		$cate= $sm->getCate();
		return array(
				'form'=>$form,
				'option'=>$cate,
				'standards'=>$standard
		);
	}
// Specification
	public function specificationAction()
	{
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$specificationForm = new SpecificationForm();
		
		// upload specificatin 
		if($this->getRequest()->isPost())
		{
			$cateId= $this->params()->fromPost('category_id');
			$file = $this->params()->fromFiles('show_image');
			$specTitle = $this->params()->fromPost('spec_title');
			$khTitle = $this->params()->fromPost('kh_spec_title');
			$specImage = strtolower ( preg_replace ( "![^a-z0-9]+!i", "-", $file['name'] ) );
				
			$field = array(
					'category_id'=>$cateId,
					'spec_image'		=> $specImage,
					'spec_title'		=> $specTitle,
					'kh_spec_title'		=> $khTitle,
			);
			$size = new Size(array('max'=>1048576));
			$adapter = new \Zend\File\Transfer\Adapter\Http();
			$adapter->setValidators(array($size), $specImage);
		
			if(! $adapter->isValid())
			{
				$message = 'Max size: 1MB';
			}else{
				$sm->saveSpecification($field);
				//store to folder
				$dir = 'public/img/specification';
				if(file_exists($dir))
				{
					move_uploaded_file($file['tmp_name'], $dir.'/'.$specImage);
				}
				return $this->redirect()->toUrl('dashboard-product-specification');
			}
		}
		
		// get data specification
		$dataSpec = $sm->getSpecification();
		$getCate = $sm->getCate();
		return array(
		'specificationForm'=>$specificationForm,
				'dataspec' =>$dataSpec,
				'option' => $getCate,
		);
	}
	//remove standard
	public function removestandardAction()
	{
		$this->layout('layout/_ajax_layout');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$id =$this->params()->fromQuery('id');
		$sm->removeStandard($id);
		return false;
	}
	
	//update standard
	public function updatestandardAction()
	{
		$this->layout('layout/_ajax_layout');
		$id = $this->params()->fromQuery('id');
		$field = array(
				'stan_title'		=> $this->params()->fromQuery('title'),
		);
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$sm->updateStandard($field, $id);
		return false;
	}
	
	// remove specification
	public function removeSpecificationAction()
	{
		$this->layout('layout/_ajax_layout');
		$sm= $this->serviceLocator->get('Admin\Model\GlobalModel');
		$spec_id = $this->params()->fromQuery('id');
		// remove image from folder
		$del = $sm->checkExistImageSpecification($spec_id);
		$dir = 'public/img/specification/'.$del[0]['spec_image'];
		unlink($dir);
		$sm->removeSpecification($spec_id);
		return false;
	}
	
	// update specification
	public function updateSpecificationAction()
	{
		$this->layout('layout/_ajax_layout');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$spec_id = $this->params()->fromQuery('id');
		$spec_title = $this->params()->fromQuery('spec_title');
		$kh_spec_title = $this->params()->fromQuery('kh_spec_title');
		$field = array(
			'spec_title'=>$spec_title,
			'kh_spec_title'=> $kh_spec_title,
		);
		$sm->updateSpecification($field,$spec_id);
		return false;
	}
	
	// filter specification
	public function filterspecificationAction()
	{
		$this->layout('layout/_ajax_layout');
		$catId = $this->params()->fromQuery('catId');
		
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$dataSpec= $sm->getFilterSpecification($catId);
		return array('dataspec'=>$dataSpec);//'dataSpec'=>$dataSpec);
	}
	//filter product by cate id
	public function productfilterAction()
	{
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$filter = $this->params()->fromQuery('id');
		$getPorductByFilter = $sm->getProductByFilter($filter);
	
		return array('product'=>$getPorductByFilter);
	}
	
	// filter standard
	public function filterstandardAction()
	{
		$this->layout('layout/_ajax_layout');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$catId = $this->params()->fromQuery('catId');
		$standards = $sm->getFilterStandard($catId);
		return array('standards'=>$standards);
	}
	//information filter by filter id
	public function informationfilterAction()
	{
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$filter = $this->params()->fromQuery('id');
	
		$info = $sm->getInfoByFilter($filter);
		return array('info'=>$info);
	}
	// filter technical 
	public function filtertechnicalAction()
	{
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$catId = $this->params()->fromQuery('id');
		$tech = $sm->getFilterTechnical($catId);
		
		return array(
			'technicals'=>$tech
		);
	}
	
	// add spec to cat
	public function addtocatAction()
	{
		$catId = $this->params()->fromQuery('catId');
		$specId = $this->params()->fromQuery('specId');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$checkSpec = $sm->checkSpecincategory($specId, $catId);
		if(count($checkSpec)>0){
			
		}else{
			$sm->addspecTocat($specId,$catId);
		}
		return $this->redirect()->toUrl('dashboard-production');
	}
	//add standard to other cate
	public function standardaddtocateAction()
	{
		$this->layout('layout/_ajax_layout');
		$id = $this->params()->fromQuery('id');
		$standard = $this->params()->fromQuery('standard');
	
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$data = array('category_id'=>$id, 'standard_id'=>$standard);
		$sm->saveStandardAddTo($data);
		return false;
	}
}












