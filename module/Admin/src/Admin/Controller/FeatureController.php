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
        $featureData = $sm->getFeature();
        return array(
            'featureData'=>$featureData,

        );
    }
    public function newfeatureAction()
    {

        $form = new FeatureForm();
        $request = $this->getRequest();
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        if($request->isPost()){
            $file = $this->params()->fromFiles('feat_image');
            $name = $file['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $newName = uniqid(). '.' . $ext;
            try{
                //store to folder
                $dir = 'public/img/feature';
                if(file_exists($dir))
                {
                    move_uploaded_file($file['tmp_name'], $dir.'/'.$newName);
                }

                // save to database
                $companyId = $this->params()->fromPost('company_id');
                $feat_started_date= $this->params()->fromPost('feat_started_date');
                $feat_end_date = $this->params()->fromPost('feat_end_date');
                $feat_ordering = $this->params()->fromPost('feat_ordering');
                $values = array(
                    'company_id' => $companyId,
                    'feat_started_date' => $feat_started_date,
                    'feat_end_date' => $feat_end_date,
                    'feat_image' => $newName,
                    'feat_ordering' => $feat_ordering
                );
                $sm->ZF2_Insert('feature',$values);
                return $this->redirect()->toUrl('admin-feature');
            }catch (\Exception $ext){
                echo 'hello';
            }
        }
        $companyData = $sm->ZF2_Select('company');
        return array(
            'form' => $form,
            'companyData' => $companyData
        );
    }
    public function editfeatureAction()
    {
        $form = new FeatureForm();
        $request = $this->getRequest();
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $feature_id = $this->params()->fromQuery('featId');
        if($request->isPost()){
            //try{
            $feat_started_date= $this->params()->fromPost('feat_started_date');
            $feat_end_date = $this->params()->fromPost('feat_end_date');
            $feat_ordering = $this->params()->fromPost('feat_ordering');
            $values = array(
                'feat_started_date' => $feat_started_date,
                'feat_end_date' => $feat_end_date,
                'feat_ordering' => $feat_ordering
            );
            $sm->ZF2_Update('feature',$values,array('feature_id'=>$feature_id));
             return $this->redirect()->toUrl('admin-feature');
//            }catch (\Exception $ext){
//                echo 'hello';
//            }
        }
        $featureData = $sm->ZF2_Select('feature',array('feature_id'=>$feature_id));
        return array(
            'form' => $form,
            'featureData' => $featureData
        );
    }
    public function deletefeatureAction()
    {
        $this->layout('layout/ajax_layout');
        $sm = $this->serviceLocator->get('Admin\Model\GlobalModel');
        $feature_id = $this->params()->fromQuery('featId');
        $featureData = $sm->ZF2_Select("feature",array("feature_id"=>$feature_id));
        unlink("public/img/feature/".$featureData[0]["feat_image"]);
        $sm->ZF2_Delete('feature',array('feature_id'=>$feature_id));

        return false;
    }
} 