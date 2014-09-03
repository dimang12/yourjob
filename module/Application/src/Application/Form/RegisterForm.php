<?php
namespace Application\Form;


use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class RegisterForm extends Form
{
    protected $inputFilter;
    public function __construct($name=null)
    {
        parent::__construct('register');
        $this->setAttributes(array('method'=>'post'));
        $this->add(array('name'=>'first_name','type' => 'Text'));
        $this->add(array('name'=>'last_name','type' => 'Text'));
        $this->add(array('name'=>'gender','type' => 'Select'));
        $this->add(array('name'=>'user_email','type' => 'Text'));
        $this->add(array('name'=>'user_name','type' => 'Text'));
        $this->add(array('name'=>'password','type' => 'Text'));
        $this->add(array('name'=>'repassword','type' => 'Text'));
        $this->add(array('name'=>'user_info','type' => 'Textarea'));

        $this->add(array('name'=>'option_register','type' => 'Select'));
        $this->add(array('name'=>'com_name','type' => 'Text'));
        $this->add(array('name'=>'contact_name','type' => 'Select'));
        $this->add(array('name'=>'com_phone','type' => 'Text'));
        $this->add(array('name'=>'com_email','type' => 'Text'));
        $this->add(array('name'=>'com_website','type' => 'Text'));
        $this->add(array('name'=>'com_service_phone','type' => 'Text'));
        $this->add(array('name'=>'com_address','type' => 'Textarea'));
        $this->add(array('name'=>'com_info','type' => 'Textarea'));

        $this->add(array('name'=>'submit','type' => 'Submit'));
    }
    public function getInputFilterUser()
    {
        $inputFilter = new InputFilter();
        $inputFilter->add(array(
            'name'=>'first_name',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'last_name',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'user_email',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'user_name',
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
            'name'=>'repassword',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'user_info',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        return $this->inputFilter = $inputFilter;
    }
    public function getInputFilterUserWithCompany()
    {
        $inputFilter = new InputFilter();
        $inputFilter->add(array(
            'name'=>'first_name',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'last_name',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'user_email',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'user_name',
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
            'name'=>'repassword',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'user_info',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        return $this->inputFilter = $inputFilter;
    }
}
