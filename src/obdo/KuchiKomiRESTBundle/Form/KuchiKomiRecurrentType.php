<?php

namespace obdo\KuchiKomiRESTBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use obdo\KuchiKomiRESTBundle\Entity\KuchiRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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
        $arrayEntity =  array();                
                
        if($options['idkuchi']!=' '){
            $idkuchi = $options['idkuchi'];
            $arrayEntity = array('class'=>'obdo\KuchiKomiRESTBundle\Entity\Kuchi',                                             
            'property'=>'name',
            'label'=>'Emetteur',
            'query_builder'=> function(KuchiRepository $kr) use ($idkuchi){
                return $kr->getKuchiQuery($idkuchi);
            });            

        } else {
            $arrayEntity = array('class'=>'obdo\KuchiKomiRESTBundle\Entity\Kuchi',                                             
            'property'=>'name',
            'query_builder'=> function(KuchiRepository $kr) use ($id){
                            return $kr->getKuchisByUserId($id); },
            'label'=>'Emetteur',
            );
                       
        }
        
        $builder
            ->add('kuchi','entity',$arrayEntity)    
            ->add('title','text', array('attr' => array('style' => 'width:100%', 'maxlength' => 40)))
            ->add('details','textarea', array('required' => false,'attr' => array('style' => 'width:100%', 'maxlength' => 300)))
            ->add('photoimg','file', array('required' => false))
            ->add('recurrence','choice', array('choices'=>(array('weekly'=>'Chaque semaine','monthly'=>'Chaque mois','yearly'=>'Chaque année','unique'=>'Une seule fois')),
                    'required'=> true, 'multiple' => false, 'label' => false, 'empty_value'=>'Choisissez la fréquence', 'empty_data'=>null))
            ->add('beginRecurrence','date')
            ->add('endRecurrence','date')
            ->add('beginTime','time', array('widget'=>'choice','input'=>'datetime', 
                'minutes'=>array(00,15,30,45),'label' => false))
            ->add('endTime','time', array('widget'=>'choice','input'=>'datetime', 
                'minutes'=>array(00,15,30,45), 'label' => false))
            ->add('endFirstTime','date')
            ->add('sendDay','choice', array('choices'=>array(range(0,30)),'empty_value'=>'Délai avant envoi','empty_data'=>"à définir"
                ,'required'=>true, 'multiple'=>false, 'label' => false));
                
                                                      
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'obdo\KuchiKomiRESTBundle\Entity\KuchiKomiRecurrent'  ,          
            'idkuchi'=>' ' 
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'obdo_kuchikomirestbundle_kuchikomirecurrent';
    }
    
        
//    public function onPreSetData(FormEvent $event)
//    {
//        $kuchikomi = $event->getData();
//        $form = $event->getForm();
//        
//        
//            if($kuchikomi->getKuchi()!=null){
//                $form ->remove('kuchi');
//                           }
//            
//        
//    }
    public function configure(){
        
    }

    
}

