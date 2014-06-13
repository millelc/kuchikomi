<?php

namespace obdo\KuchiKomiRESTBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('raissoc')
            ->add('telcli')
            ->add('mailcli')
            ->add('ruecli')
            ->add('noruecli')
            ->add('codposcli')
            ->add('villecli')
            ->add('nomcontact', 'text', array('required' => false,))
            ->add('titrecontact', 'choice', array('choices'   => array(
                                            'Mme'   => 'Madame',
                                            'Mle' => 'Mademoiselle',
                                            'Mr'   => 'Monsieur',
                                        ),
                                        'multiple' => false,
                                        'expanded' => true,
                                        'required' => false,
                                        'empty_value' => 'Choisir un titre',
                                        'empty_data'  => null))
            ->add('telcontact', 'text', array('required' => false,))
            ->add('mailcontact', 'text', array('required' => false,))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'obdo\KuchiKomiRESTBundle\Entity\Clients'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'obdo_kuchikomirestbundle_clients';
    }
}
