<?php

namespace obdo\KuchiKomiRESTBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use obdo\KuchiKomiRESTBundle\Entity\KuchiRepository;

class KuchiKomiType extends AbstractType
{
    
    
    public $iduser;
    
    function __construct($iduser) {
       $this->iduser = $iduser;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $this->iduser;
        $arrayEntity =  array();                
                
        if($options['kuchi']!='Oui'){
            $arrayEntity = array('class'=>'obdo\KuchiKomiRESTBundle\Entity\Kuchi',                                             
            'property'=>'name',
            'query_builder'=> function(KuchiRepository $kr) use ($id){
                            return $kr->getKuchisByUserId($id); },
            'multiple'=>false,
            'expanded'=>false,
            'label'=>'Emetteur',
            'empty_value'=> "Choisir l'émetteur"); 
            $builder
            ->add('kuchi','entity', $arrayEntity);
        }
        $builder
            ->add('title','text', array('attr' => array('style' => 'width:100%', 'maxlength' => 40)))
            ->add('timestampBegin','datetime', array('minutes'=>array(00,15,30,45)))
            ->add('timestampEnd','datetime', array('minutes'=>array(00,15,30,45)))
            ->add('details','textarea', array('required' => false,'attr' => array('style' => 'width:100%', 'maxlength' => 300)))
            ->add('photoimg','file', array('required' => false,
                ));
        
    }
    
            
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver->setDefaults(array(
            'data_class' => 'obdo\KuchiKomiRESTBundle\Entity\KuchiKomi',                        
            'kuchi'=>' '
             )); 
        
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'obdo_kuchikomirestbundle_kuchikomi';
    }

}
