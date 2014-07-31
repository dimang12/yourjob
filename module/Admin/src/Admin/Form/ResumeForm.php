<?php
namespace Admin\Form;


use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ResumeForm extends Form
{
    protected $inputFilter;
    public function __construct($name=null)
    {
        parent::__construct('resume');
        $this->setAttributes(array('method'=>'post','enctype'=>'multipart/form-data'));

        $this->add(array(
            'name'=>'resu_image',
            'type' => 'File',
            'attributes'=>array(
                'class'=>'form-control',
            ),
            'options'=>array(
                'label' => 'Choose Image'
            )
        ));
        $this->add(array(
            'name'=>'job_id',
            'type' => 'hidden'
        ));
        $this->add(array(
            'name'=>'user_id',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'city_id',
            'type' => 'Select',
            'attributes'=>array(
                'class'=>'form-control'
            ),
            'options'=>array(
                'label' => 'Province / City'
            )
        ));
        $this->add(array(
            'name'=>'category_id',
            'type' => 'Select',
            'attributes'=>array(
                'class'=>'form-control'
            ),
            'options'=>array(
                'label' => 'Category'
            )
        ));
        $this->add(array(
            'name'=>'resu_current_position',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            ),
            'options'=>array(
                'label' => 'Current Position'
            )
        ));
        $this->add(array(
            'name'=>'resu_position',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            ),
            'options'=>array(
                'label' => 'Apply For'
            )
        ));

        $this->add(array(
            'name'=>'resu_schedule',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            ),
            'options'=>array(
                'label' => 'Schedule'
            )
        ));
        $this->add(array(
            'name'=>'resu_age',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            ),
            'options'=>array(
                'label' => 'Age'
            )
        ));
        $this->add(array(
            'name'=>'resu_gender',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            ),
            'options'=>array(
                'label' => 'Gender'
            )
        ));
        $this->add(array(
            'name'=>'resu_salary',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            ),
            'options'=>array(
                'label' => 'Salary'
            )
        ));
        $this->add(array(
            'name'=>'resu_year_experience',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            ),
            'options'=>array(
                'label' => 'Year of Experience'
            )
        ));
        $this->add(array(
            'name'=>'resu_language',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            ),
            'options'=>array(
                'label' => 'Language'
            )
        ));
        $this->add(array(
            'name'=>'resu_interesting',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            ),
            'options'=>array(
                'label' => 'Interesting'
            )
        ));
        $this->add(array(
            'name'=>'resu_skill',
            'type' => 'Textarea',
            'attributes'=>array(
                'class'=>'form-control'
            ),
            'options'=>array(
                'label' => 'Skill'
            )
        ));
        $this->add(array(
            'name'=>'resu_posting_date',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            ),
            'options'=>array(
                'label' => 'Posting Date'
            )
        ));
    }
}
