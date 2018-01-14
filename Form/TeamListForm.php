<?php

namespace Charlotte\StaffBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TeamListForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('team', 'entity', array(
                                                    'label'     => 'Hériter des rôles d\'un autre groupe : ',
                                                    'required'  => true,
                                                    'class' => 'CharlotteStaffBundle:Team',
                                                    'property' => 'name',
                                            ))
                ->add('teamId', 'hidden');
    }

    public function getName()
    {
        return 'TeamListForm';
    }
}