<?php

namespace obdo\KuchiKomiRESTBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AppelFormType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateappel', 'datetime')
            ->add('nomcorresp', 'text')
            ->add('telcorresp', 'text')
            ->add('titreappel', 'text')
            ->add('raisonappel','textarea')
            ->add('solution','textarea')
            ->add('temps','integer')
            ->add('client', 'entity', array(
                    'class'    => 'obdoKuchiKomiRESTBundle:Clients',
                    'property' => 'raissoc',
                    'multiple' => false,
                    'required' => true))
            ->add('typeappel', 'entity', array(
                    'class'    => 'obdoKuchiKomiRESTBundle:TypeAppel',
                    'property' => 'description',
                    'multiple' => false,
                    'required' => false,
                    'empty_value' => 'Choisir un type'))
            ->add('newtype', 'text', array(
                'required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'obdo\KuchiKomiRESTBundle\Form\AppelForm'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'obdo_kuchikomirestbundle_appelform';
    }
}
