<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 12/21/14
 * Time: 10:24 PM
 */

namespace Admin\Controller;

use Application\Controller\MainController;
use Application\Model\ExperienceShareTable;
use Zend\View\Model\ViewModel;


class ExperienceController extends MainController
{

    /**
     * @return array|ViewModel
     */
    public function indexAction(){
        /*
         * declare variables
         */
        $page = $this->params()->fromQuery("page", 1);
        $db = new ExperienceShareTable();

        $experience = $db->getList("","expr_post_date DESC");
        $paginator  = $this->getPaginator($experience,$page,15);

        /*
         * return data to view
         */
        return new ViewModel(array(
            "data" => $paginator
        ));
    }


    public function detailAction(){
        /*
         * declare variables
         */
        $id = $this->params()->fromRoute("id");
        $db = new ExperienceShareTable();

        $data = $db->getDetail($id);

        print_r($data);
        /*
         * pass data to view
         */
        return new ViewModel(array(
            "data" => current($data)
        ));
    }


}