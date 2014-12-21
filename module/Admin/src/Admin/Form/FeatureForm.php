<?php
namespace Admin\Form;
use Zend\Form\Form;

class FeatureForm extends Form
{
    public function __construct($name=null){
        parent::__construct('feature');
        $this->setAttributes(array('method'=>'post','enctype'=>'multipart/form-data'));

        $this->add(array(
            'name' =>'feat_image',
            'attributes' => array(
                'type' 	=>'file'
            ),
            'options'  =>array(
                'label' =>'Upload Logo',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes'	=> array(
                'type' => 'Zend\Form\Element\Submit',
                'value' => 'Upload',
            )
        ));

        $this->add(array(
            'name' => 'feat_started_date',
            'attributes' => array(
                'type' => 'Zend\Form\Element\Text'
            ),
            'options' =>array(
                'label' => 'Posting Date',
            ),
        ));
        $this->add(array(
            'name' => 'feat_end_date',
            'attributes' => array(
                'type' => 'Zend\Form\Element\Text'
            ),
            'options' =>array(
                'label' => 'Deadline:',
            ),
        ));
        $this->add(array(
            'name' => 'company_name',
            'type' => 'Zend\Form\Element\Text',
            'options' =>array(
                'label' => 'Company:',
            ),
        ));
        $this->add(array(
            'name' => 'feat_ordering',
            'attributes' => array(
                'type' => 'Zend\Form\Element\Text'
            ),
            'options' =>array(
                'label' => 'Order Number:',
            ),
        ));
    }

}