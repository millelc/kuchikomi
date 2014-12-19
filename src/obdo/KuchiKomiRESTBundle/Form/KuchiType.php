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
            ->add('password',     	'repeated', 
                    array('type'=>'password',
                        'invalid_message'=>"les mots de passe ne sont pas identiques",
                        'first_options'=> 'Tapez votre mote de passe',
                        'second_options'=> 'Tapez à nouveau votre mot de passe'))
            ->add('phoneNumber',     	'text')
            ->add('mailAddress',        'email', array('required' => false,'empty_data' => ''))
            ->add('webSite',            'url', array('required' => false,'empty_data' => '', 'data' => 'http://'))
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
