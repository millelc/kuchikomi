<?php

namespace obdo\KuchiKomiRESTBundle\Form;

use Symfony\Component\Form\AbstractType;
use obdo\KuchiKomiRESTBundle\Form\AddressType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KuchiType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',     		'text')
            ->add('password',     	'text')
            ->add('phoneNumber',     	'text')
            ->add('mailAddress',        'text', array('required' => false,))
            ->add('webSite',            'text', array('required' => false,))
            ->add('address', 		 new AddressType())
            ->add('logoimg',            'file')
            ->add('photoimg',           'file')
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
