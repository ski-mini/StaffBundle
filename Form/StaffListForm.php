<?php

namespace Charlotte\StaffBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

class StaffListForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('staff', 'entity', array(
                                                    'label'     => 'Choisir un utilisateur à modifier',
                                                    'required'  => true,
                                                    'class' => 'CharlotteStaffBundle:Staff',
                                                    'property' => 'initials',
                                                    'query_builder' => function(EntityRepository $er) {
                                                                            return $er->createQueryBuilder('s')
                                                                                      ->where('s.enabled = 1')
                                                                                      ->orderBy('s.initials', 'ASC');
                                                                        },
                                            ));
    }

    public function getName()
    {
        return 'StaffListForm';
    }
}