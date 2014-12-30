<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 12/6/14
 * Time: 3:15 PM
 */
namespace Application\Controller;

use Zend\View\Model\ViewModel;

class InfoController extends MainController
{
    /**
     * @return ViewModel
     */
    public function aboutAction(){
        return new ViewModel(array(

        ));
    }

    /**
     * @return ViewModel
     */
    public function contactAction(){
        return new ViewModel(array(

        ));
    }

    /**
     * @return ViewModel
     */
    public function serviceAction(){
        return new ViewModel(array(

        ));
    }

    public function feedbackAction(){
        /*
         * declare
         */

        /*
         * return to view
         */
        return new ViewModel(array(

        ));
    }

}