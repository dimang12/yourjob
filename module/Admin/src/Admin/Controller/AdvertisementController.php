<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\SlideForm;
use Zend\Validator\File\Size;
use Admin\Model\GlobalModel;

class AdvertisementController extends AbstractActionController {
    public function indexAction() {
        $sm = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
        $form = new SlideForm ();
        $controlName = $this->params ()->fromPost ( 'slid_control' );
        $file = $this->params ()->fromFiles ( 'slid_image' );
        $image = $file ['name'];
        $ext = pathinfo ( $image, PATHINFO_EXTENSION );
        $newName = uniqid () . '.' . $ext;
        $order = $this->params ()->fromPost ( 'slid_order' );
        $title = $this->params ()->fromPost ( 'slid_title' );
        $kh_title = $this->params ()->fromPost ( 'kh_slid_title' );
        $slideDesc = $this->params()->fromPost('slid_desc');
        $kh_slideDesc = $this->params()->fromPost('kh_slid_desc');

        if ($this->getRequest ()->isPost ()) {

            $size = new Size ( array (
                'max' => 1048576
            ) ); // 1MB
            $adapter = new \Zend\File\Transfer\Adapter\Http ();
            $adapter->setValidators ( array (
                $size
            ), $newName );

            if (! $adapter->isValid ()) {
                $error = 'Max size (1MB)';
            } else {
                $data = array (
                    'slid_control' => $controlName,
                    'slid_title' => $title,
                    'kh_slid_title' => $kh_title,
                    'slid_image' => $newName,
                    'slid_order' => $order,
                    'slid_desc'		=> $slideDesc,
                    'kh_slid_desc'		=> $kh_slideDesc,

                );

                // save to mysql database
                $sm->uploadSlide ( $data );

                // store to folder
                $dir = 'public/img/slide';
                if (file_exists ( $dir )) {
                    move_uploaded_file ( $file ['tmp_name'], $dir . '/' . $newName );
                }
            }
        }
        $slide = $sm->getSlide ();

        return array (
            'form' => $form,
            'slide' => $slide
        );
    }

    // ajax remove slide by id
    public function removeslideAction() {
        $this->layout ( 'layout/_ajax_layout' );
        $id = $this->params ()->fromQuery ( 'Id' );
        $sm = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );

        $exist = $sm->checkSlide ( $id );
        // remove image in folder
        $dir = 'public/img/slide/' . $exist [0] ['slid_image'];
        unlink ( $dir );
        // delete in database table
        $sm->removeSlide ( $id );
        return false;
    }

    // edit slide
    public function editslideAction() {
        $sm = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
        $form = new SlideForm ();
        $sid = $this->params ()->fromQuery ( 'sid' );
        // get slide by id
        $slide = $sm->getSlideById ( $sid )->current ();
        $form->bind ( $slide );

        $controlName = $this->params ()->fromPost ( 'slid_control' );

        $order = $this->params ()->fromPost ( 'slid_order' );
        $title = $this->params ()->fromPost ( 'slid_title' );
        $kh_title = $this->params ()->fromPost ( 'kh_slid_title' );
        $slideDesc = $this->params()->fromPost('slid_desc');
        $kh_slideDesc = $this->params()->fromPost('kh_slid_desc');
        if ($this->getRequest ()->isPost ()) {

            $data = array (
                'slid_control' => $controlName,
                'slid_title' => $title,
                'kh_slid_title' => $kh_title,
                'slid_image' => $newName,
                'slid_order' => $order,
                'slid_desc'		=> $slideDesc,
                'kh_slid_desc'		=> $kh_slideDesc,

            );

            //save to mysql database
            $sm->updateSlideById($data, $sid);
            return $this->redirect()->toUrl("admin-slide");
        }
        return array('form'=>$form);
    }

    //filter slide by control name
    public function filterslideAction()
    {
        $this->layout('layout/_ajax_layout');
        $filter = $this->params()->fromQuery('filter');
        $sm = $this->serviceLocator->get ( 'Admin\Model\GlobalModel' );
        $slideFilter = $sm->getFilterSlide($filter);

        return array('slide'=>$slideFilter);
    }
}