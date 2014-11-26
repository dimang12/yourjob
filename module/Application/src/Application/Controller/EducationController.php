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
            $form->setInputFilter($formValidator->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $db = new EducationTable($this->getAdapter());
                $values = $this->params()->fromPost();
                $values ["educ_post_date"] = date("Y-m-d");
                unset($values["_wysihtml5_mode"]);

                //save to table
                $db->save($values);
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