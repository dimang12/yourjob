<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 7/2/14
 * Time: 10:07 PM
 */

namespace Application\Controller;

use Application\Form\EducationForm;
use Application\Form\EducationValidator;
use Application\Model\EducationTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EducationController extends  AbstractActionController{

    public function indexAction(){

        $db = new EducationTable($this->getAdapter());
        $eduData = $db->getAllEducation();

        return new ViewModel(array(
            "eduData"=>$eduData
        ));
    }

    /*
     * action add
     */
    public function addAction()
    {
        $form = new EducationForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $formValidator = new EducationValidator();
            print_r($request->getFiles());
            $form->setInputFilter($formValidator->getInputFilter());$post = array_merge_recursive($request->getPost()->toArray, $request->getFiles()->toArray());

            $form->setData($request->getPost());

            if ($form->isValid()) {

            }
        }

        return new ViewModel(array(
            "form" => $form
        ));
    }

    /*
     * action detail
     */
    public function detailAction(){

    }

    public function getAdapter(){
        return $this->getServiceLocator()->get("Zend\Db\Adapter\Adapter");
    }


} 