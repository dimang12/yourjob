<?php
namespace Application\Form;


use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class RegisterForm extends Form
{
    protected $inputFilter;
    public  $optRegister;   // optRegister = 1 mean create new seeker  else create employer
    public function __construct($name=null)
    {
        parent::__construct('register');
        $this->setAttributes(array('method'=>'post'));
        $this->add(array('name'=>'first_name','type' => 'Text'));
        $this->add(array('name'=>'last_name','type' => 'Text'));
        $this->add(array('name'=>'gender','type' => 'Select'));
        $this->add(array('name'=>'user_email','type' => 'Text'));
        $this->add(array('name'=>'user_name','type' => 'Text'));
        $this->add(array('name'=>'password','type' => 'Password'));
        $this->add(array('name'=>'repassword','type' => 'Password'));
        $this->add(array('name'=>'user_info','type' => 'Textarea'));
        $this->add(array('name'=>'user_address','type' => 'Textarea'));
        $this->add(array('name'=>'user_phone','type' => 'Text'));

        $this->add(array('name'=>'option_register','type' => 'Select'));
        $this->add(array('name'=>'com_name','type' => 'Text'));
        $this->add(array('name'=>'contact_name','type' => 'Text'));
        $this->add(array('name'=>'com_phone','type' => 'Text'));
        $this->add(array('name'=>'com_email','type' => 'Text'));
        $this->add(array('name'=>'com_website','type' => 'Text'));
        $this->add(array('name'=>'com_service_phone','type' => 'Text'));
        $this->add(array('name'=>'com_address','type' => 'Textarea'));
        $this->add(array('name'=>'com_info','type' => 'Textarea'));

        //$this->add(array('name'=>'submit','type' => 'Submit'));
    }
    public function getInputFilter()
    {
        if($this->optRegister==1){
            return $this->getInputFilterUser();
        }elseif($this->optRegister==2){
            return $this->getInputFilterUserWithCompany();
        }elseif($this->optRegister==3){
            return $this->getInputFilterUpdateCompany();
        }
    }
    public function getInputFilterUser()
    {
        $inputFilter = new InputFilter();
        $inputFilter->add(array(
            'name'=>'user_phone',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'user_address',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
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
            'validators' => array(
                new \Zend\Validator\EmailAddress()
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
            'name' => 'repassword', // add second password field
            /* ... other params ... */
            'validators' => array(
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'password', // name of first password field
                    ),
                ),
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
            'name'=>'user_phone',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'user_address',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
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
            'validators' => array(
                new \Zend\Validator\EmailAddress()
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
            'name' => 'repassword', // add second password field
            /* ... other params ... */
            'validators' => array(
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'password', // name of first password field
                    ),
                ),
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
        $inputFilter->add(array(
            'name'=>'com_name',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'contact_name',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'com_phone',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'com_email',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
            'validators' => array(
                new \Zend\Validator\EmailAddress()
            ),
        ));
        $inputFilter->add(array(
            'name'=>'com_website',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'com_service_phone',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'com_address',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'com_info',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        return $this->inputFilter = $inputFilter;
    }
    public function getInputFilterUpdateCompany()
    {
        $inputFilter = new InputFilter();

        $inputFilter->add(array(
            'name'=>'com_name',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'contact_name',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'com_phone',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'com_email',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
            'validators' => array(
                new \Zend\Validator\EmailAddress()
            ),
        ));
        $inputFilter->add(array(
            'name'=>'com_website',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'com_service_phone',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'com_address',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        $inputFilter->add(array(
            'name'=>'com_info',
            'required'=>true,
            'filters'=>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
        ));
        return $this->inputFilter = $inputFilter;
    }
}
