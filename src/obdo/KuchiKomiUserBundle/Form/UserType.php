<?php

namespace obdo\KuchiKomiUserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{

    public function __construct($rolesChoices)
    {
        $this->rolesChoices = $rolesChoices;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('password')
            ->add('roles', 'choice', array('choices' => $this->rolesChoices, 'multiple' => true))
            ->add('client', 'entity', array(
                    'class'    => 'obdoKuchiKomiRESTBundle:Clients',
                    'property' => 'raissoc',
                    'multiple' => false,
                    'required' => false))
            ->add('kuchigroups', 'entity', array(
                    'class'    => 'obdoKuchiKomiRESTBundle:KuchiGroup',
                    'property' => 'name',
                    'multiple' => true,
                    'required' => false))
            ->add('kuchis', 'entity', array(
                    'class'    => 'obdoKuchiKomiRESTBundle:Kuchi',
                    'property' => 'name',
                    'multiple' => true,
                    'required' => false));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'obdo\KuchiKomiUserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'obdo_kuchikomiuserbundle_user';
    }
}
