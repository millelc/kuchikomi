<?php

namespace obdo\KuchiKomiUserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use obdo\KuchiKomiRESTBundle\Entity\KuchiRepository;

class UserKuchiType extends AbstractType
{
    public function __construct($rolesChoices, $userid)
    {
        $this->rolesChoices = $rolesChoices;
        $this->userid = $userid;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userid = $this->userid;
        $builder
            ->add('username', 'text', array('required' => false,))
            ->add('email', 'text', array('required' => false,))
            ->add('password', 'password', array('required' => false,))
            ->add('roles', 'choice', array('choices' => $this->rolesChoices, 
                                           'multiple' => true, 
                                           'required' => false,))
            ->add('kuchigroups', 'entity', array(
                    'class'    => 'obdoKuchiKomiRESTBundle:KuchiGroup',
                    'property' => 'name',
                    'multiple' => true,
                    'required' => false))
            ->add('kuchis', 'entity', array(
                    'class'    => 'obdoKuchiKomiRESTBundle:Kuchi',
                    'property' => 'name',
                    'multiple' => true ,
                    'query_builder' => function(KuchiRepository $r)
                    use($userid) {
                    return $r->getKuchisByUserId($userid);
                    }));
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
