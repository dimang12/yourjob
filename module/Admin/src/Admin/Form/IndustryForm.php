<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 11/3/14
 * Time: 7:40 PM
 */

namespace Admin\Form;


class IndustryForm extends \Zend\Form\Form
{
    /*
     * initialize class through constructor
     */
    public function __construct($name = "industryForm"){
        parent::__construct('industryForm');
        $this->setAttributes(array('method'=> 'post'));
        $this->setAttribute('class', 'form-inline');
        $this->add(array(
            'name' => 'indu_parent',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label'=>'Industry parent',
                'options' => array(

                ),
            ),
        ));

        $this->add(array(
            'name'	=>'indu_name',
            'attributes'	=>array(
                'type'		=>'Zend\Form\Element\Text',
            ),
            'options'	=>array(
                'label'	=>'Industry Name'
            ),
        ));
        $this->add(array(
            'name'	=>'kh_indu_name',
            'attributes'	=>array(
                'type'		=>'Zend\Form\Element\Text',
            ),
            'options'	=>array(
                'label'	=>'Industry(kh)'
            ),
        ));
        $this->add(array(
            'name'	=>'indu_order',
            'attributes'	=>array(
                'type'		=>'Zend\Form\Element\Text',
            ),
            'options'	=>array(
                'label'	=>'Ordering'
            ),
        ));

        $this->add(array(
            'name'	=>'indu_image',
            'attributes'	=>array(
                'type'		=>'file',
            ),
            'options'	=>array(
                'label'	=>'Image (show on home page)'
            ),
        ));
        $this->add(array(
            'name'	=>'indu_details',
            'attributes'	=>array(
                'type'		=>'Zend\Form\Element\Textarea',
                'placeholder'=>'here...'
            ),
            'options'	=>array(
                'label'	=>'Industry Detail '
            ),
        ));
        $this->add(array(
            'name'	=>'kh_indu_details',
            'attributes'	=>array(
                'type'		=>'Zend\Form\Element\Textarea',
                'placeholder'=>'here...'
            ),
            'options'	=>array(
                'label'	=>' Description(kh)'
            ),
        ));

        $this->add(array(
            'name'=>'submit',
            'attributes'=>array(
                'type'=>'Zend\Form\Element\Submit',
                'value'=>'Save'
            ),
        ));
    }
}