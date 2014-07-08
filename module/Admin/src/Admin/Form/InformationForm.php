<?php
namespace Admin\Form;
use Zend\Form\Form;
class InformationForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('information');
		$this->setAttributes(array('method'=> 'post'));
		
		$this->add(array(
			'name' => 'category_id',
			'type' => 'Zend\Form\Element\Select',
			    'options' => array(
			    	'label'=>'Select category',
			        'options' => array(			            
			    ),
			 ),
		));
		
		$this->add(array(
				'name'	=>'info_desc',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Textarea',
				),
				'options'	=>array(
						'label'	=>'Information'	
				),
		));
		$this->add(array(
				'name'	=>'kh_info_desc',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Textarea',
				),
				'options'	=>array(
						'label'	=>'Information(kh)'
				),
		));
		$this->add(array(
				'name'	=>'info_gene',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Textarea',
				),
				'options'	=>array(
						'label'	=>'General'
				),
		));
		$this->add(array(
				'name'	=>'kh_info_gene',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Textarea',
				),
				'options'	=>array(
						'label'	=>'General(kh)'
				),
		));
		$this->add(array(
				'name'	=>'info_color',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Textarea',
				),
				'options'	=>array(
						'label'	=>'Color '
				),
		));
		$this->add(array(
				'name'	=>'kh_info_color',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Textarea',
				),
				'options'	=>array(
						'label'	=>'Color(kh)'
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