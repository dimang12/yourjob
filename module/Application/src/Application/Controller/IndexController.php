<?php

namespace Application\Controller;

use Application\Model\AclTable;
use Application\Model\CategoriesTable;

use Application\Model\EducationTable;
use Application\Model\LocationTable;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

use Zend\Session\Container;;
use Zend\Session\Container as SessionContainer;


class IndexController extends AbstractActionController
{
	public function indexAction()
    {
        $cateDb = new CategoriesTable($this->getCategoriesTableGateway());
        $eduDb = new EducationTable($this->getAdapter());
        $locDB = new LocationTable($this->getAdapter());

        $urgentJob = $cateDb->getNewestJob();
        $newEducation = $eduDb->getLatestEducation();
        $allLocation = $locDB->getAllLocationJobs();

        return new ViewModel(array(
            "categories" => $cateDb->getAllCate(),
            "urgentJob" => json_encode($urgentJob),
            "education" => $newEducation,
            "locations" => $allLocation
        ));
    }



    public function categoryAction(){
        //declare params
        $cateId =  $this->params()->fromQuery("c");
        $page = $this->params()->fromQuery("page",1);
        $cateDb = new CategoriesTable($this->getCategoriesTableGateway());
        $jobs = array();

        //it is won't works if category id is empty
        if(!empty($cateId)){
            $jobs = $cateDb->getJobByCate($cateId);
        }

        $paginator = new Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($jobs));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(20);


        //pass params to view
        return new ViewModel(array(
            "jobs" => $jobs,
            'paginator'=>$paginator,
            "category"=>$cateId
        ));
    }

    /*
     * location action
     * param l is id of location
     */
    public function locationAction(){
        $locationId =  $this->params()->fromQuery("l");
        $page = $this->params()->fromQuery("page",1);
        $locationDb = new LocationTable($this->getAdapter());
        $jobs = array();
        $cityInfo = array();

        //it is won't works if category id is empty
        if(!empty($locationId)){
            $jobs = $locationDb->getJobByCity($locationId);
            $cityInfo = $locationDb->getLocation($locationId);

        }

        $paginator = new Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($jobs));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(20);


        //pass params to view
        return new ViewModel(array(
            "jobs" => $jobs,
            'paginator'=>$paginator,
            "category"=>$locationId,
            "city" => $cityInfo
        ));
    }

    public function jobdtAction(){
        //declare params
        $jobId = $this->params()->fromQuery("job");
        $db = new CategoriesTable($this->getCategoriesTableGateway());
        $jobDetail = $relatedJob = $recommendJob = null;

        if(!empty($jobId)){
            $jobDetail = $db->getJobDetail($jobId);

        }

        return new ViewModel(
            array(
                "jobDetail"=>current($jobDetail)
            )
        );
    }

    public function searchAction(){
        //get and declare params
        $txtSearch = $this->params()->fromQuery("s");
        
    }
    

    private function getCategoriesTableGateway(){
        return new TableGateway("categories",$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
    }

    private function getAdapter(){
        return $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    }
}
