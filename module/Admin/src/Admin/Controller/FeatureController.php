<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 7/6/14
 * Time: 12:13 AM
 */

namespace Admin\Controller;


use Admin\Form\FeatureForm;
use Zend\Mvc\Controller\AbstractActionController;

class FeatureController extends AbstractActionController {

    public function indexAction(){

        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $featureData = $sm->ZF2_Query("SELECT * FROM feature f INNER  JOIN company c ON f.company_id = c.company_id");
        return array(
            'featureData'=>$featureData,

        );
    }
    public function newfeatureAction()
    {
        $form = new FeatureForm();
        return array(
            'form' => $form
        );
    }
    public function editfeatureAction()
    {
        $form = new FeatureForm();
        return array(
            'form' => $form
        );
    }
    public function deletefeatureAction()
    {
        $form = new FeatureForm();
        return array(
            'form' => $form
        );
    }
} 