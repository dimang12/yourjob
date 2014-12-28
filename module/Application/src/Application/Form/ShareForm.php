<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 12/6/14
 * Time: 1:44 PM
 */

namespace Application\Form;



use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;


class ShareForm extends Form
{
    protected $inputeFilter;

    public function __construct($name = null)
    {
        parent::__construct('');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'shar_title',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Type something...',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Title:',
            ),
        ));

        $this->add(array(
            'name' => 'shar_post_by',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'company or university name',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Post by:',
            ),
        ));

        $this->add(array(
            'name' => 'shar_start_date',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Type something...',
                'required' => 'required',
                'step' => '1',
            ),
            'options' => array(
                'label' => 'Start Date:',
            ),
        ));

        $this->add(array(
            'name' => 'shar_address',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control address',
                'placeholder' => 'Type address...',
//                'required' => 'required',

                'step' => '1',
            ),
            'options' => array(
                'label' => 'Address:',
            ),
        ));

        $this->add(array(
            'name' => 'shar_phone',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Type phone number...',
//                'required' => 'required',

                'step' => '1',
            ),
            'options' => array(
                'label' => 'Phone Number:',
            ),
        ));

        $this->add(array(
            'name' => 'shar_email',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Type email address...',
//                'required' => 'required',

                'step' => '1',
            ),
            'options' => array(
                'label' => 'Email Address:',
            ),
        ));


        $this->add(array(
            'name' => 'shar_website',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Type website...',
                'required' => 'required',

                'step' => '1',
            ),
            'options' => array(
                'label' => 'Website:',
            ),
        ));

        $this->add(array(
            'name' => 'shar_close_date',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Type something...',
                'required' => 'required',

                'step' => '1',
            ),
            'options' => array(
                'label' => 'Close date:',
            ),
        ));

        $this->add(array(
            'name' => 'shar_contact',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control contact',
                'placeholder' => 'click here',
            ),
            'options' => array(
                'label' => 'Contact information',
            ),
        ));

        $this->add(array(
            'name' => 'image',
            'type' => 'file',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Image',
            ),
        ));

        $this->add(array(
            'name' => 'shar_detail',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
                'rows' => 10
            ),
            'options' => array(
                'label' => "Description:"
            ),
        ));

        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));
    }


    public function getInputFilter(){
        $inputFilter = new InputFilter();

        return $inputFilter;

    }
}