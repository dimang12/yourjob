<?php
namespace Admin\Form;


use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class AdvForm extends Form
{
    protected $inputFilter;
    public function __construct($name=null)
    {
        parent::__construct('advertisement');
        $this->setAttributes(array('method'=>'post','enctype'=>'multipart/form-data'));

        $this->add(array(
            'name'=>'adv_title',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control',
            )
        ));
        $this->add(array(
            'name'=>'adv_desc',
            'type' => 'Textarea',
            'attributes'=>array(
                'class'=>'form-control',
            )
        ));
        $this->add(array(
            'name'=>'adv_ordering',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control',
            )
        ));
        $this->add(array(
            'name'=>'adv_image',
            'type' => 'File',
            'attributes'=>array(
                'class'=>'form-control',
            )
        ));
    }
    public function getInputFilter(){
        $inputFilter = new InputFilter();
        $inputFilter->add(array(
            'name'=>'adv_title',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'     => 'adv_ordering',
            'filters'  => array(
                array('name' => 'Int'),
            ),
            'validators' => array(
                array(
                    'name' => 'Between',
                    'options' => array(
                        'min' => 1,
                        'max' => 500,
                        'message' => 'Please input Number'
                    ),
                ),
            ),
        ));
        return $this->inputFilter= $inputFilter;
    }
}
