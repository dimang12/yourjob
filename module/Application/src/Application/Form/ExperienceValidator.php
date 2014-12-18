<?php
/**
 * Created by PhpStorm.
 * User: dimang12
 * Date: 12/15/14
 * Time: 2:18 PM
 */

namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ExperienceValidator implements InputFilterAwareInterface
{
    protected $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        $inputFilter = new InputFilter();
        $factory = new InputFactory();


        $inputFilter->add($factory->createInput([
            'name' => 'expr_post_by',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
            ),
        ]));


        $inputFilter->add($factory->createInput([
            'name' => 'expr_contact',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
            ),
        ]));

        $inputFilter->add($factory->createInput([
            'name' => 'image',
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(

            ),
        ]));

        $inputFilter->add($factory->createInput([
            'name' => 'expr_detail',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
            ),
        ]));

        $this->inputFilter = $inputFilter;


        return $this->inputFilter;
    }
}

