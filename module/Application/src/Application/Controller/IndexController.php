<?php

namespace Application\Controller;

use Application\Model\AclTable;
use Application\Model\AdvertisementTable;
use Application\Model\CategoriesTable;

use Application\Model\EducationTable;
use Application\Model\ExperienceShareTable;
use Application\Model\FeatureTable;
use Application\Model\JobTable;
use Application\Model\LocationTable;
use Application\Model\SalaryTable;
use Application\Model\ShareTable;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

use Zend\Session\Container;;
use Zend\Session\Container as SessionContainer;


class IndexController extends MainController
{
	public function indexAction()
    {
        //declare variables
        $cateDb = new CategoriesTable($this->getCategoiesTableGateway());

        $eduDb = new EducationTable($this->getAdapter());
        $locatDB = new LocationTable($this->getAdapter());
        $featureDb = new FeatureTable($this->getAdapter());
        $docDb = new ShareTable();
        $salaryDb = new SalaryTable();


        $feature = $featureDb->getFeatures();
        $urgentJob = $cateDb->getNewestJob();
        $newEducation = $eduDb->getLatestEducation();
        $docShare = $docDb->getList("shar_approval=1","share_id DESC",6);
        $salary = $salaryDb->getList();


        return new ViewModel(array(
            "categories" => $cateDb->getAllCate("cate_name ASC")->toArray(),
            "urgentJob" => json_encode($urgentJob),
            "education" => $newEducation,
            "locations" => $locatDB->getAllLocationJobs(),
            "feature" => $feature,
            "industries" => $cateDb->getAllIndustries(),
            "document" => $docShare,
            "salary" => $salary
        ));
    }


    /**
     * @return ViewModel
     */
    public function categoryAction(){
        /*
         * declare params
         */
        $cateId =  $this->params()->fromQuery("c");
        $page = $this->params()->fromQuery("page",1);
        $min = $this->params()->fromQuery("min");
        $max = $this->params()->fromQuery("max");
        $cateDb = new CategoriesTable($this->getCategoiesTableGateway());
        $advsDb = new AdvertisementTable();
        $jobs = array();
        $detail = array();
        $advertisement = array();

        //it is won't works if category id is empty
        $jobs = $cateDb->getJobByCate($cateId);
        if(!empty($cateId)){
            $detail = $cateDb->getDetail($cateId);
        }

        if(!empty($min) && !empty($max)){
            $jobs =$cateDb->getJobBySalary($min, $max);
        }

        $advertisement = $advsDb->getList("","adv_ordering ASC", "10");

        $paginator = new Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($jobs));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(20);


        /*
         * pass params to view
         */
        return new ViewModel(array(
            "jobs" => $jobs,
            'paginator'=>$paginator,
            "category"=>$cateId,
            "cateDetail" => current($detail),
            "advs" => $advertisement
        ));
    }

    /*
     * location action
     */
    public function locationAction(){
        //declare params
        $cityId =  $this->params()->fromRoute("id");
        $page = $this->params()->fromQuery("page",1);
        $db = new LocationTable($this->getAdapter());
        $jobs = array();

        //it is won't works if category id is empty
        if(!empty($cityId)){
            $jobs = $db->getJobByCity($cityId);
        }

        $paginator = new Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($jobs));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(20);


        //pass params to view
        return new ViewModel(array(
            "jobs" => $jobs,
            'paginator'=>$paginator,
            "cityId"=>$cityId,
            "city" => $db->getLocation($cityId)
        ));
    }

    /**
     * view job detail
     * @return ViewModel
     */
    public function jobdtAction(){
        //declare params
        $jobId = $this->params()->fromQuery("job");
        $db = new CategoriesTable($this->getCategoiesTableGateway());
        $jobDetail = $relatedJob = $recommendJob =  null;
        $relatedJob = $recommendJob = array();

        if(!empty($jobId)){
            $jobDetail = $db->getJobDetail($jobId);
            $relatedJob = $db->getRelatedJob($jobDetail[0]["company_id"]);
            $recommendJob  = $db->getRecommendedJob($jobDetail[0]["category_id"]);
        }


        /*
         * pass param to view
         */
        return new ViewModel(
            array(
                "jobDetail"=>current($jobDetail),
                "relatedJob"=>$relatedJob,
                "recommendedJob" =>$recommendJob
            )
        );
    }

    public function searchAction(){
        //get and declare params
        $page = $this->params()->fromQuery("page",1);
        $txtSearch = $this->params()->fromQuery("s");
        $db = new JobTable($this->getAdapter());
        $jobs = $db->search($txtSearch);

        $paginator = new Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($jobs));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(20);

        //pass to layout
        $this->layout()->txtSearch = $txtSearch;

        return new ViewModel(array(
            "search" => $txtSearch,
            "paginator" => $paginator

        ));
    }
    

    private function getCategoiesTableGateway(){
        return new TableGateway("categories",$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
    }
}
