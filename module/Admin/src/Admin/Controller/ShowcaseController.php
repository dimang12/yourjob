<?php
namespace Admin\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\ShowcaseForm;
use Admin\Form\CustomShowcaseForm;
use Zend\Validator\File\Size;
class ShowcaseController extends AbstractActionController
{
	public function indexAction()
	{
		// defaul sms
		$error = '';
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$showcaseForm = new ShowcaseForm();
		if($this->getRequest()->isPost())
		{
			$noneFile = $this->getRequest()->getPost()->toArray();
			$file = $this->params()->fromFiles('show_image');
			$showTitle = $this->params()->fromPost('show_title');
			$data = array_merge($noneFile, array('show_image'=> $file['name']));
			$showcaseForm->setData($data);

			if($showcaseForm->isValid())
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
					$newName = uniqid(). '.' . $ext;
					
					$data = array('show_image' => $newName, 'show_title'=>$showTitle);
					
					//save to mysql database
					$sm->uploadImageShowcase($data);
					
					//store to folder
					$dir = 'public/img/showcase/large';
					if(file_exists($dir))
					{
						move_uploaded_file($file['tmp_name'], $dir.'/'.$newName);
					}					
					foreach($sizes as $w => $h){
						$sm->resizeImage($w, $h, $dir, $type, $newName);
					}
					
				}
			}
		}

		//display image that have been upload to database
		$getShowcaseImage = $sm->getShowcaseImage();
		
		return array('active'=>'active','showcaseForm' => $showcaseForm, 'error' => $error, 'getShowcaseImage'=> $getShowcaseImage);
	}
	
	//delete showcase by ajax
	public function deleteshowcaseAction()
	{
		$this->layout('layout/ajax_layout');
		$showcaseId = $this->params()->fromQuery('showcaseId');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$del = $sm->checkExistImage($showcaseId);
		$dir = 'public/img/showcase/large/'.$del[0]['show_image'];
		unlink($dir);
		
		$dir = 'public/img/showcase/small/'.$del[0]['show_image'];
		unlink($dir);
		
		$sm->deleteShowcaseById($showcaseId);
		return true;
	}
	
	//customize showcase images
	public function customizeshowcaseAction()
	{
		$customId = $this->params()->fromQuery('customId');
		$customForm = new CustomShowcaseForm();
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		//$option = $sm->getProductAlias();
		$largeImage = $sm->checkExistImage($customId);
		$largeImage = $largeImage[0]['show_image'];
		
		
		//declear variable get data from form
		$scenDesc = $this->params()->fromPost('scen_desc');
		$prodAlias = $this->params()->fromPost('prod_alias');
		$scenPlacement = $this->params()->fromPost('scen_placement');
		$scenSkewx = $this->params()->fromPost('scen_skewx');
		$scenSkewy = $this->params()->fromPost('scen_skewy');
// 		$top = $this->params()->fromPost('scen_top');
// 		$left = $this->params()->fromPost('scen_left');
		
		$idHidden = $this->params()->fromPost('id-hidden');
				
		//get secene
		$getScene = $sm->getScene($customId);
		
		if($this->getRequest()->isPost())
		{

			$data = array(
					'showcase_id'=>$customId,
					'scen_desc'=>$scenDesc,
					'prod_alias'=>$prodAlias,
// 					'scen_top' => $top,
// 					'scen_left'=>$left,
					'scen_placement'=>$scenPlacement,
					'scen_skewx'=>$scenSkewx,
					'scen_skewy'=>$scenSkewy,
			);
			$customForm->setData($data);
			
			if($customForm->isValid())
			{
				$sm->SaveCustomize($data, $idHidden);
				return $this->redirect()->toUrl("dashboard-showcase-customize?customId=$customId");
			}
		}
		return array(
				'customForm'=>$customForm, 
				//'option'=> $option, 
				'largeImage'=>$largeImage, 
				'scene_id'=>$customId,
				'getScene'=> $getScene
		);
	}
	
	public function createsceneAction()
	{
		$this->layout('layout/_ajax_layout');
		$id = $this->params()->fromQuery('scene_id');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$sm->createscene(array('showcase_id'=>$id));
		return false;
	}
	
	public function updateondropAction()
	{
		$this->layout('layout/_ajax_layout');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$left = $this->params()->fromQuery('left');
		$top = $this->params()->fromQuery('top');
		$sceneId= $this->params()->fromQuery('id');
		$values = array('scen_left'=> $left, 'scen_top'=> $top);
		$sm->updateondrop($sceneId,$values);
		return false;
	}

	//remove secen
	public function removesceneAction()
	{
		$this->layout('layout/_ajax_layout');
		$id = $this->params()->fromQuery('id');
		$sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
		$sm->removeSceneById($id);
		return false;
	}
}