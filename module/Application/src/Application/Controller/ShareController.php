<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 12/4/14
 * Time: 10:03 PM
 */
namespace Application\Controller;

use Application\Form\ShareForm;
use Application\Form\ShareValidator;
use Application\Model\EducationTable;
use Application\Model\ShareTable;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;


class ShareController extends MainController
{

    /*
     * index action
     */
    public function indexAction(){
        $page = $this->params()->fromQuery("page",1);

        $db = new ShareTable($this->getAdapter());
        $share = $db->getAllShare(1);


        $paginator = new Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($share));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);

        return new ViewModel(array(
            "paginator"=>$paginator
        ));
    }

    /**
     * detail action
     * @return ViewModel
     */
    public function detailAction(){
        $id = $this->params()->fromRoute("id");
        $db = new ShareTable();
        $share = $db->getDetail($id);


        return new ViewModel(array(
            "share" => current($share)
        ));
    }

    /**
     * @return ViewModel
     */
    public function addAction(){
        $form = new ShareForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $formValidator = new ShareValidator();
            $form->setInputFilter($formValidator->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $db = new ShareTable($this->getAdapter());

                $values = $this->params()->fromPost();
                $values ["shar_post_date"] = date("Y-m-d");
                unset($values["_wysihtml5_mode"]);


                //upload file
                $file = $this->params()->fromFiles('image');

                $name = $file['name'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $newName = uniqid(). '.' . $ext;

                $dir = getcwd()."/public/img/share/";
                if(file_exists($dir)){
                    move_uploaded_file($file['tmp_name'], $dir.'/'.$newName);
                }

                $values["shar_img"] = $newName;

                //save to table
                $db->save($values);
                $this->redirect()->toUrl($this->getRequest()->getBaseUrl()."/document-share");
            }
        }

        return new ViewModel(array(
            "form" => $form
        ));
    }


}