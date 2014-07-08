<?php
namespace Admin\Form;
use Zend\Form\Form,
    Zend\Form\Element,
    Zend\InputFilter\Factory as InputFactory,
	Zend\InputFilter\InputFilter;
class LoginForm extends Form
{
	public function __construct($n = null)
	{
		parent::__construct('login');
		$this->setAttributes(array(
			'method'	=>'post',
			'class'		=>'form-horizontal',
		));
		
		$username = new Element\Text('username');
		$username->setAttributes(array(	'placeholder' 	=>'Username ',	'class'	=>'form-control'));
		$this->add($username);
		
		$password = new Element\Password('password');
		$password->setAttributes(array('placeholder' => 'Password ', 'class' =>'form-control'));
		$this->add($password);
		
		$csrf = new Element\Csrf('csrf');
		$this->add($csrf);
		
		$submit = new Element\Submit('btnlogin');
		$submit->setValue('Log In');
		$submit->setAttributes(array('class'=>'btn btn-success'));
		$this->add($submit);
		
		//validating filter element
		$filter = new InputFilter();
		$factory = new InputFactory();
		$filter->add($factory->createInput(array(
			'name'	=> 'username',
			'required'	=> true,
			'filters'  => array(
        				array('name' => 'StringTrim'),
        			),
        		'validators' => array(
        				array(
        				      'name' => 'StringLength',
        					  'options' => array(
        							'min' => 4
        						)
        				)
        			)
		)));
		$filter->add($factory->createInput(array(
				'name'	=> 'password',
				'required'	=> true,
				'filters'  => array(
						array('name' => 'StringTrim'),
				),
				'validators' => array(
						array(
								'name' => 'StringLength',
								'options' => array(
										'min' => 4
								)
						)
				)
		)));
		
		$filter->add($factory->createInput(array(
        		'name'	=> 'csrf',
        		'required' => true,
        		'validators' => array(
        				array(
        					'name' => 'Csrf',
        					'options' => array(
        							'timeout' => 600
        						)
        				)
        			)
        	)));
		
		$this->setInputFilter($filter);
	}
}