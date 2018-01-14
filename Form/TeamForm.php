<?php

namespace Charlotte\StaffBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TeamForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('team', 'entity', array(
                                                    'label'     => 'Choisir un groupe à modifier',
                                                    'required'  => false,
                                                    'class' => 'CharlotteStaffBundle:Team',
                                                    'property' => 'name',
                                            ))
                ->add('name', 'text', array(
                                                'label' => 'Ou créer un nouveau groupe',
                                                'required' => false,
                                            ));
    }

    public function getName()
    {
        return 'TeamForm';
    }
}