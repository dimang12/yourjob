<?php
namespace Admin\Controller;
use Admin\Form\ByondForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Validator\File\Size;
use Zend\Mvc\Controller\Plugin\Redirect;
class BeyondController extends AbstractActionController
{
	public function indexAction()
	{
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$byondform = new ByondForm();
		$error='';
		if($this->getRequest()->isPost())
		{
			$noneFile = $this->getRequest()->getPost()->toArray();
			$file = $this->params()->fromFiles('show_image');
			$showTitle = $this->params()->fromPost('live_title');
			$kh_live_title=$this->params()->fromPost('kh_live_title');
			$live_desc= $this->params()->fromPost('live_desc');
			$kh_live_desc=$this->params()->fromPost('kh_live_desc');
			$live_parent = $this->params()->fromPost('live_parent');
			
			// get parent 
			$parentTitle = $this->params()->fromPost('parent_title');
			$kh_parent_title = $this->params()->fromPost('kh_parent_title');
			if(!empty($parentTitle)){
				$parentData =array('live_title'=>$parentTitle,'kh_live_title'=>$kh_parent_title);
				$sm ->InsertParentBeyondLiving($parentData);
				return $this->redirect()->toRoute('dashboard-beyondliving');
			}
				
			$data = array_merge($noneFile, array('show_image'=> $file['name']));
			$byondform->setData($data);
		
			if($byondform->isValid())
			{
				$size = new Size(array('max' => 1048576)); // 1MB
				$adapter = new \Zend\File\Transfer\Adapter\Http();
				$adapter->setValidators(array($size), $file['name']);
				
				if(! $adapter->isValid())
				{
					$error = 'Max size (1MB)';
						
				}else {
					$sizes = array(80 => 80);
					
					$name = $file['name'];
					
					$type = $file['type'];
					$ext = pathinfo($name, PATHINFO_EXTENSION);
					//$newName = $name. '.' . $ext;
					$newName = uniqid(). '.' . $ext;
						
					$data = array('show_image' => $newName, 'live_title'=>$showTitle,'kh_live_title'=>$kh_live_title,'live_desc'=>$live_desc,'kh_live_desc'=>$kh_live_desc,'live_parent'=>$live_parent);
						
					//save to mysql database
					$sm->uploadImageBeyondLiving($data);
						
					//store to folder
					$dir = 'public/img/beyond/original';
					if(file_exists($dir))
					{
						move_uploaded_file($file['tmp_name'], $dir.'/'.$newName);
					}
					foreach($sizes as $w => $h){
						$sm->resizeImageLiving($w, $h, $dir, $type, $newName);
					}
						
				}
			}
		}
		//display image that have been upload to database
		$getBeyondLivingImage = $sm->getBeyondLivingImage();	

		// get live parent
		$parentData = $sm->getLiveParent();
		
		return  array('byondform'=>$byondform,'getBeyondLivingImage'=>$getBeyondLivingImage,'parent'=>$parentData,'error'=>$error);
	}

	//delete Beyond Living by ajax
	public function deletebeyondAction()
	{
		$this->layout('layout/ajax_layout');
		$livingId = $this->params()->fromQuery('livingId');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$del = $sm->checkExistImageBeyondLiving($livingId);
		$dir = 'public/img/beyond/original/'.$del[0]['live_image'];
		unlink($dir);
	
		$dir = 'public/img/beyond/small/'.$del[0]['live_image'];
		unlink($dir);
	
		$sm->deleteBeyondById($livingId);
		return true;
	}
	
	public function customizebeyondAction()
	{
		$customId = $this->params()->fromQuery('customId');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$byondform = new ByondForm();
		
		// Get largeImage
		$largeImage = $sm->checkExistImageBeyondLiving($customId);
		$largeImage = $largeImage[0]['live_image'];
		
		// update 
		if($this->getRequest()->isPost())
		{
			$showTitle = $this->params()->fromPost('live_title');
			$kh_live_title=$this->params()->fromPost('kh_live_title');
			$live_desc= $this->params()->fromPost('live_desc');
			$kh_live_desc=$this->params()->fromPost('kh_live_desc');
			$live_parent = $this->params()->fromPost('live_parent');
			
			$data = array('living_id' => $customId, 'live_title'=>$showTitle,'kh_live_title'=>$kh_live_title,'live_desc'=>$live_desc,'kh_live_desc'=>$kh_live_desc,'live_parent'=>$live_parent);
			
			//Update to mysql database
			$sm->updateImageBeyondLiving($data);
			return $this->redirect()->toRoute('dashboard-beyondliving');
		}
		
		// Get Value to show in textbox
		$dataUpdat = $sm->getBeyondLivingById($customId);
		
		// get live parent
		$parentData = $sm->getLiveParent();
		
		return array('byondform'=>$byondform,'largeImage'=>$largeImage,'data'=>$dataUpdat,'parent'=>$parentData);
	}
	
	// remove parent 
	public function removeParentAction()
	{
		$this->layout('layout/ajax_layout');
		$parentId = $this->params()->fromQuery('parent-id');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$sm->removeParent($parentId);
		return true;
	}
	public function updateParentAction()
	{
		$this->layout('layout/ajax_layout');
		$parentId = $this->params()->fromQuery('parent-id');
		$live_title = $this->params()->fromQuery('live_title');
		$kh_live_title = $this->params()->fromQuery('kh_live_title');
		$data = array('live_title'=>$live_title,'kh_live_title'=>$kh_live_title);
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$sm ->updateParent($data,$parentId);
		return true;
	}
}

