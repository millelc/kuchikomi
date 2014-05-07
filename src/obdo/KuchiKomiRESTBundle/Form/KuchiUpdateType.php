<?php

namespace obdo\KuchiKomiRESTBundle\Form;

use Symfony\Component\Form\AbstractType;
use obdo\KuchiKomiRESTBundle\Form\AddressType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KuchiUpdateType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',     		'text', array('required' => false,))
            ->add('password',     	'password', array('required' => false,))
            ->add('phoneNumber',     	'text', array('required' => false,))
            ->add('mailAddress',        'text', array('required' => false,))
            ->add('webSite',            'text', array('required' => false,))
            ->add('address', 		 new AddressUpdateType())
            ->add('logoimg',            'file', array('required' => false,))
            ->add('photoimg',            'file', array('required' => false,));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'obdo\KuchiKomiRESTBundle\Entity\Kuchi'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'obdo_kuchikomirestbundle_kuchi';
    }
}
