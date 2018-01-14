<?php

namespace Charlotte\StaffBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TableForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('bundle', 'text');
        $builder->add('entity', 'text');
    }

    public function getName()
    {
        return 'TableForm';
    }
}