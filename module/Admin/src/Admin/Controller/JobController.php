<?php
namespace Admin\Controller;
use Admin\Form\JobForm;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 7/5/14
 * Time: 11:52 PM
 */

class JobController extends AbstractActionController{
    public function indexAction(){
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $jobData = $sm->ZF2_Query("SELECT * FROM  job INNER JOIN city ON job.city_id = city.city_id");
        return array(
            'jobData'=>$jobData,
        );
    }
    public function jobpostingAction()
    {
        $form = new JobForm();

        return array(
            'form' => $form,
        );
    }
}