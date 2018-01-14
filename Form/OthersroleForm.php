<?php

namespace Charlotte\StaffBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class OthersroleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', 'choice', array(
                                                'label' => 'Choisissez un type de role',
                                                'required' => true,
                                                'choices' => array(
                                                                        'acl' => 'Accès',
                                                                        'create'  => 'Création',
                                                                        'file'    => 'Possibilité de voir/modifier/supprimer un fichier',
                                                                        'mail'  => 'Envoi de mail',
                                                                        'sms'  => 'Envoi de sms',
                                                                    ),
                                        ))
                ->add('name', 'text', array(
                                                'label' => 'Nom du role',
                                                'required' => true,
                                                'pattern' => '[a-zA-Z-]+',
                                        ))
                ->add('description', 'text', array(
                                                'label' => 'Description',
                                                'required' => true,
                                        ));
    }

    public function getName()
    {
        return 'OthersroleForm';
    }
}