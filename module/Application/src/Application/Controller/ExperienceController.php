<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 12/14/14
 * Time: 9:50 PM
 */

namespace Application\Controller;

use Application\Form\ExperienceForm;
use Application\Form\ExperienceValidator;
use Application\Model\ExperienceShareTable;
use Zend\View\Model\ViewModel;
use Zend\View\View;

class ExperienceController extends MainController
{

    /**
     * index action
     * @return array|View
     */
    public function indexAction(){
        /*
         * declare params
         */
        $page = $this->params()->fromQuery("page",1);
        $db = new ExperienceShareTable();

        $video = $db->getList("expr_type=2");
//        $paginator = $this->getPaginator($experience, $page, 10);

        $document = $db->getList("expr_type=1");
        /*
         * return data to view
         */
        return new ViewModel(array(
            "video" => $video,
            "document" => $document
        ));
    }

    /**
     * display detail of experience video or document
     * @return ViewModel
     */
    public function detailAction(){
        /*
         * declare params
         */
        $videoId = $this->params()->fromRoute("id");
        $db = new ExperienceShareTable();

        $detail = $db->getDetail($videoId);

        $related = $db->getRelated($videoId);

        /*
         * return values to view
         */
        return new ViewModel(array(
            "data" => current($detail),
            "related" => $related
        ));
    }


    /**
     * add experience share to database table
     * @return ViewModel
     */
    public function addAction(){
        /*
         * declare variable
         */
        $form = new ExperienceForm();
        $request = $this->getRequest();


        if ($request->isPost()) {
            $formValidator = new ExperienceValidator();
            $form->setInputFilter($formValidator->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $db = new ExperienceShareTable();

                $values = $this->params()->fromPost();
                $values ["expr_post_date"] = date("Y-m-d");
                unset($values["_wysihtml5_mode"]);


                //upload file
                if($this->params()->fromFiles('image')){

                    $file = $this->params()->fromFiles('image');

                    $name = $file['name'];
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $newName = uniqid(). '.' . $ext;

                    $dir = getcwd()."/public/img/experience/";
                    if(file_exists($dir)){
                        move_uploaded_file($file['tmp_name'], $dir.'/'.$newName);
                    }

                    $values["expr_img"] = $newName;
                }

                //save to table
                $db->save($values);
                $this->redirect()->toUrl($this->getRequest()->getBaseUrl()."/experience-share");
            }
        }


        /*
         * return values to view
         */
        return new ViewModel(array(
            'form' => $form
        ));
    }
}