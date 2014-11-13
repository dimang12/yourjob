<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 11/3/14
 * Time: 12:11 PM
 */
namespace Admin\Controller;

use Admin\Form\CateForm;
use Admin\Form\IndustryForm;
use Zend\Mvc\Controller\AbstractActionController;

class IndustryController extends AbstractActionController
{

    /*
     * index action
     */
    public function indexAction(){
        $sm = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
        $catData = $sm->ZF2_Select('industries');

        $page = $this->params()->fromQuery('page');
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($catData));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(4);
        return array (
            'catData' => $paginator
        );
    }

    public function addAction(){
        $form = new IndustryForm();
        $induName = $this->params ()->fromPost ( 'indu_name' );
        $induOrder = $this->params ()->fromPost ( 'indu_order' );
        $induDetails = $this->params ()->fromPost ( 'indu_details' );
        $sm = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
        if ($this->getRequest ()->isPost ()) {
            $values = array (
                'indu_name' => $induName,
                'indu_order' => $induOrder,
                'indu_details' => $induDetails,
            );
            $sm->ZF2_Insert('industries',$values);
            return $this->redirect()->toUrl('dashboard-industry');
        }
        return array (
            'form' => $form,
        );
    }

    public function editAction(){
        $form = new IndustryForm();
        $cateId = $this->params ()->fromQuery ( 'catId' );
        $sm = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
        if($this->getRequest()->isPost())
        {
            $cateName = $this->params ()->fromPost ( 'indu_name' );
            $cateOrder = $this->params ()->fromPost ( 'indu_order' );
            $cateDetails = $this->params ()->fromPost ( 'indu_details' );
            $values = array (
                'indu_name' => $cateName,
                'indu_order' => $cateOrder,
                'indu_details' => $cateDetails,
            );
            $sm->ZF2_Update('industries',$values,array('industry_id'=>$cateId));
            return $this->redirect()->toUrl('dashboard-industry');
        }
        $catData = $sm->ZF2_Select_AllColumn('industries',array('industry_id'=>$cateId));
        return array('form'=>$form,'catData'=>$catData);
    }
}