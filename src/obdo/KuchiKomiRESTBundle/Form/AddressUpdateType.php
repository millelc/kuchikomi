<?php

namespace obdo\KuchiKomiRESTBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressUpdateType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address1',   'text', array('required' => false,))
            ->add('address2',   'text', array('required' => false,))
            ->add('address3',   'text', array('required' => false,))
            ->add('postalCode', 'text', array('required' => false,))
            ->add('city',       'text', array('required' => false,))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'obdo\KuchiKomiRESTBundle\Entity\Address'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'obdo_kuchikomirestbundle_address';
    }
}
