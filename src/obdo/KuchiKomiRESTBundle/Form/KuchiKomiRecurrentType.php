<?php

namespace obdo\KuchiKomiRESTBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use obdo\KuchiKomiRESTBundle\Entity\KuchiRepository;

class KuchiKomiRecurrentType extends AbstractType
{
    private $iduser;
    
    function __construct($iduser) {
        $this->iduser = $iduser;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)            
    {
        $id =  $this->iduser;
        $builder
            ->add('kuchi','entity',array('class'=>'obdo\KuchiKomiRESTBundle\Entity\Kuchi',                                             
            'property'=>'name',
            'query_builder'=> function(KuchiRepository $kr) use ($id){
                            return $kr->getKuchisByUserId($id); },
            'multiple'=>false,
            'expanded'=>false,            
            'empty_value'=> "Choisir l'émetteur"))
            ->add('title','text', array('attr' => array('style' => 'width:100%', 'maxlength' => 40)))
            ->add('details','textarea', array('required' => false,'attr' => array('style' => 'width:100%', 'maxlength' => 300)))
            ->add('photoLink','file', array('required' => false))
            ->add('recurrence','choice', array('label'=>'Souhaitez-vous répéter ce message :','choices'=>(array('w'=>'Chaque semaine ','m'=>' Chaque mois ')),
                    'required'=> true, 'expanded'=> true, 'multiple' => false))
            ->add('beginRecurrence','datetime')
            ->add('endRecurrence','datetime')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'obdo\KuchiKomiRESTBundle\Entity\KuchiKomiRecurrent'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'obdo_kuchikomirestbundle_kuchikomirecurrent';
    }
}
