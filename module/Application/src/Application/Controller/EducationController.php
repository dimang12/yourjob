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
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class EducationController extends  AbstractActionController{

    public function indexAction(){

        $page = $this->params()->fromQuery("page",1);

        $db = new EducationTable($this->getAdapter());
        $eduData = $db->getAllEducation();


        $paginator = new Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($eduData));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);

        return new ViewModel(array(
            "eduData"=>$paginator
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

//                print_r($file);

                //upload file
                $file = $this->params()->fromFiles('image');
                $name = $file['name'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $newName = uniqid(). '.' . $ext;

                $dir = getcwd()."/public/img/education/";
                if(file_exists($dir)){
                    move_uploaded_file($file['tmp_name'], $dir.'/'.$newName);
                }

                $values["educ_img"] = $newName;

                //save to table
                $db->save($values);

                $this->redirect()->toUrl($this->getRequest()->getBaseUrl()."/education");
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