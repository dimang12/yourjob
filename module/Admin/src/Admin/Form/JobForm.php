<?php
namespace Admin\Form;


use Zend\Form\Form;

class JobForm extends Form
{
    public function __construct($name=null)
    {
        parent::__construct('job');
        $this->setAttributes(array('method'=>'post'));
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
            'name'=>'job_name',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_schedule',
            'type' => 'Text'
        ));
        $this->add(array(
            'name'=>'job_salary_type',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_salary_from',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_salary_to',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_age_from',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_age_to',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_year_experience',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_language',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_hiring_number',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_description',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_duty',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_requirement',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_published_date',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_close_date',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_date_reseted',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
            )
        ));
        $this->add(array(
            'name'=>'job_status',
            'type' => 'Text',
            'attributes'=>array(
                'class'=>'form-control'
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
}
