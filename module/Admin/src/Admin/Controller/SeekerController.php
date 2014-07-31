<?php
namespace Admin\Controller;
use Admin\Form\ResumeForm;
use Zend\Mvc\Controller\AbstractActionController;

class SeekerController extends AbstractActionController
{
    public function indexAction()
    {
        $sm= $this->serviceLocator->get('admin\Model\GlobalModel');
        $resumeData = $sm->ZF2_Select('resume',array());
        return array(
            'resumeData' => $resumeData
        );
    }
    public function newresumeAction()
    {
        $form = new ResumeForm();
        return array(
            'form' => $form
        );
    }
    public function editresumeAction()
    {

    }
}