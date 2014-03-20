<?php

namespace obdo\KuchiKomiRESTBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address1',   'text')
            ->add('address2',   'text')
            ->add('address3',   'text')
            ->add('postalCode', 'text')
            ->add('city',       'text')
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
