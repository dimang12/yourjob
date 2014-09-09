<?php
namespace Admin\Form;


use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class UserForm extends Form
{
    protected $inputFilter;
    public function __construct($name=null)
    {
        parent::__construct('user');
        $this->setAttributes(array('method'=>'post'));
        $this->add(array(
            'name'=>'username',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control',
            )
        ));
        $this->add(array(
            'name'=>'password',
            'type' => 'Password',
            'attributes'=>array(
                'class'=>'form-control',
            )
        ));
        $this->add(array(
            'name'=>'address',
            'type' => 'Textarea',
            'attributes'=>array(
                'class'=>'form-control',
            )
        ));
        $this->add(array(
            'name'=>'email',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control',
            )
        ));
        $this->add(array(
            'name'=>'phone',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control',
            )
        ));
        $this->add(array(
            'name'=>'gender',
            'type' => 'Select',
            'attributes'=>array(
                'class'=>'form-control',
            )
        ));
        $this->add(array(
            'name'=>'website',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control',
            )
        ));
        $this->add(array(
            'name'=>'info',
            'type' => 'Textarea',
            'attributes'=>array(
                'class'=>'form-control',
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
    }
    public function getInputFilter()
    {
        $inputFilter = new InputFilter();
        $inputFilter->add(array(
            'name'=>'username',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'password',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'phone',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'email',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
            'validators' => array(
                new \Zend\Validator\EmailAddress()
            ),
        ));
        return $this->inputFilter = $inputFilter;
    }
}
