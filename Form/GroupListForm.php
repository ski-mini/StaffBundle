<?php

namespace Charlotte\StaffBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

class GroupListForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('team', 'entity', array(
                                                    'label'     => ' ',
                                                    'required'  => true,
                                                    'class' => 'CharlotteStaffBundle:Team',
                                                    'property' => 'name',
                                                    'query_builder' => function(EntityRepository $er) {
                                                                            return $er->createQueryBuilder('s')
                                                                                      ->orderBy('s.name', 'ASC');
                                                                        },
                                            ))
                ->add('staffId', 'hidden');
    }

    public function getName()
    {
        return 'GroupListForm';
    }
}