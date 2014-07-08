<?php
namespace Admin\Form;
use Zend\Form\Form;
class ShowcaseForm extends Form
{
	public function __construct($n = null)
	{
		parent:: __construct('upload');
		$this->setAttributes(array('method'=>'post', 'enctype'=>'multipart/form-data'));
		$this->setUseInputFilterDefaults(false);
		
		$this->add(array(
				'name'	=>'show_image',
				'attributes'	=>array(
					'type'		=>'file',
				),
				'options'	=>array(
						'label'	=>'Choose an Image',
						
				),
		));
		$this->add(array(
				'name'	=>'show_title',
				'attributes'	=>array(
						'type'		=>'Zend\Form\Element\Text',
				),
				'options'	=>array(
						'label'	=>'Image Title',
		
				),
		));
		$this->add(array(
				'name'=>'submit',
				'attributes'=>array(
						'type'=>'Zend\Form\Element\Submit',
						'value'=>'Upload',
							
				),
		));
	}
}