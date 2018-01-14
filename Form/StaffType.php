<?php

namespace Charlotte\StaffBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StaffType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contracttype', 'entity', array( 'class' => 'CharlotteStaffBundle:Contracttype', 'property'     => 'value', ))
            ->add('nation', 'entity', array( 'class' => 'CharlotteMainBundle:Nation', 'property'     => 'value', ))
            ->add('serviceoffice', 'entity', array( 'class' => 'CharlotteStaffBundle:Serviceoffice', 'property'     => 'value', ))
            ->add('initials')
            ->add('gender')
            ->add('firstname')
            ->add('lastname')
            ->add('postcode')
            ->add('city')
            ->add('address1')
            ->add('address2')
            ->add('professionalphone')
            ->add('professionalfax')
            ->add('professionalmail')
            ->add('profesionnalcopymail')
            ->add('internalphone')
            ->add('personnalmail')
            ->add('personnalphone')
            ->add('personnalmobile')
            ->add('menucolapsedbydefault')
            ->add('sign')
            ->add('dateofbirth')
            ->add('dateofstart')
            ->add('dateofend')
            ->add('picture')
            ->add('socialsecuritynumber')
            ->add('registrationnumber')
            ->add('idcart')
            ->add('rib')
            ->add('archived')
            ->add('groups', 'entity', array( 'class' => 'CharlotteStaffBundle:Team', 'property'     => 'name', ))
            ->add('maritalstatus', 'entity', array( 'class' => 'CharlotteStaffBundle:Maritalstatus', 'property'     => 'value', ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Charlotte\StaffBundle\Entity\Staff',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'charlotte_staffbundle_staff';
    }
}
