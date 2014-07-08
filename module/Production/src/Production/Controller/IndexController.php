<?php
namespace Production\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Production\Model\ProductTable;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Zend\Captcha\Factory;
use Admin\Model\GlobalModel;
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	
    	$sm = $this->serviceLocator->get("Production\Model\ProductTable");
        $getCate = $sm->getCate();               
        $getProduct = $sm->getProduct();
    	    
       	$s = $this->serviceLocator->get("Admin\Model\GlobalModel");
		$slide = $s->getSlideByController("Product");		
		$this->layout()-> img = $slide;
        
        $cateId = "";
        $cateId = $this->params()->fromQuery('cateId');
       	$getProByCateId = $sm->getProdNew($cateId);
       
     	return array(
     		"cateId"	=> $cateId,
        	"getCate"	=> $getCate, 
     		"getProduct"	=> $getProduct,
     		"paginator" => $getProByCateId,
     	);
    }
    
    public function infoAction()
    {
    	
    	$sm = $this->serviceLocator->get("Production\Model\ProductTable");
    	$getCate = $sm->getCate();
    	$prodAlias = $this->params()->fromRoute("products");    	
    	$getProdId = $sm->getProductId($prodAlias);
    	$prodId = $getProdId[0]['product_id'];
    	$cateId = $getProdId[0]['category_id'];
    	
    	$getProdTitle = $sm->getProdTitle($prodId);
    	$getCode = $getProdTitle[0]['prod_mate_code'];
    	
    	$getInfo = $sm->getInfo($cateId); 
    	
    	$getImage = $sm->getImage($prodId);
    	$getImage = $getImage[0]['imag_name'];
    	$getSpecification = $sm->getSpecification($cateId);
		$getStandard = $sm->getStandard($cateId);
		$getTechnical = $sm->getTechnical($cateId);
		$getImages = $sm->getImages($prodId);
		
		//still active product menu
		$this->layout()->active = 'active';
		
		$s = $this->serviceLocator->get("Admin\Model\GlobalModel");
		$slide = $s->getSlideByController("Product");		
		$this->layout()-> img = $slide;
		
		return array(
        	"getCate"	=> $getCate,
			"getInfo"	=> $getInfo,
			"getTitle"	=> $getProdTitle,
			"getCode"	=> $getCode,
	   		"getImage"	=> $getImage ,
	   		"getSpecification"	=> $getSpecification,
	   		"getStandard"	=> $getStandard,
			"getTechnical"	=> $getTechnical,
			"getImages"	=> $getImages,
			"curCateId"	=> $cateId,
			
        );
    }

    public function viewmoreAction()
    {
   		//still active product menu
    	$this->layout()->active = 'active';
     	$s = $this->serviceLocator->get("Admin\Model\GlobalModel");
		$slide = $s->getSlideByController("Product");		
		$this->layout()-> img = $slide;
		
    	$cateIds = "";
    	$cateIds = $this->params()->fromQuery('cateId');
    	$sm = $this->serviceLocator->get("Production\Model\ProductTable");
    	$cateAlias = $this->params()->fromRoute("application");
    	$getCateId = $sm->getCateId($cateAlias);
    	
    	$cateId = $getCateId[0]['category_id'];
    	$getCateTitle = $getCateId[0]['cate_name'];    	
    	
    	$getCate = $sm->getCate();  
    	$paginator = $sm->getProdNew($cateId);
    	$count = count($paginator);
//     	$paginator = new Paginator(new paginatorIterator($paginator)); // not working maybe add later
//     	$paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1))
//     	->setItemCountPerPage(8)->setPageRange(5);
    	
    	return new ViewModel(array(
    		"cateId" => $cateIds,
    		"cateTitle" => $getCateTitle,
    		"getCate"	=> $getCate,
   			"curCateId"	=> $cateId,
   			"paginator" => $paginator,
    		"cateAlias"	=> $cateAlias,
   			"count"	=>	$count,
    	
    	));
    }
    
    public function seriesAction()
    {
    	//still active product menu
    	$this->layout()->active = 'active';
    	$s = $this->serviceLocator->get("Admin\Model\GlobalModel");
		$slide = $s->getSlideByController("Product");		
		$this->layout()-> img = $slide;
		
    	$sm = $this->serviceLocator->get("Production\Model\ProductTable");
    	$cateAlias = $this->params()->fromRoute('series');
    	$getCateId = $sm->getCateId($cateAlias);
		$cateId = $getCateId[0]['category_id'];
    	$getCateTitle = $getCateId[0]['cate_name'];
    	$getCate = $sm->getCate();

    	$getProdByCateId = $sm->getProdByCateId($cateId); 
    	  	
//     	$getProdByCateId = new Paginator(new paginatorIterator($getProdByCateId));
//     	$getProdByCateId->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1))
//     	->setItemCountPerPage(8);
    	return new ViewModel(array(
    		"getCate"	=> $getCate,
  			"cateTitle" => $getCateTitle,
    		"getProdByCateId"	=> $getProdByCateId,
    		"curCateId"	=> $cateId,
    		"cateAlias"	=> $cateAlias	
    	));
    }
}
