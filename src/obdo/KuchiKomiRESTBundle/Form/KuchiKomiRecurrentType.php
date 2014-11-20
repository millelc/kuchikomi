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
        $builder
            ->add('kuchi','entity',array('class'=>'obdo\KuchiKomiRESTBundle\Entity\Kuchi',                                             
            'property'=>'name',
            'query_builder'=> function(KuchiRepository $kr) use ($id){
                            return $kr->getKuchisByUserId($id); },
            'multiple'=>false,
            'expanded'=>false,            
            'empty_value'=> "Choisir l'émetteur",
            'required'=>true))
            ->add('title','text', array('attr' => array('style' => 'width:100%', 'maxlength' => 40)))
            ->add('details','textarea', array('required' => false,'attr' => array('style' => 'width:100%', 'maxlength' => 300)))
            ->add('photoimg','file', array('required' => false))
            ->add('recurrence','choice', array('label'=>'Répétition du message :','choices'=>(array('weekly'=>'Chaque semaine ','monthly'=>' Chaque mois ','yearly'=>'Chaque année')),
                    'required'=> true, 'multiple' => false))
            ->add('beginRecurrence','date')
            ->add('endRecurrence','date')
            ->add('beginTime','time', array('widget'=>'choice','model_timezone'=>'Europe/Berlin','input'=>'datetime'))
            ->add('endTime','time', array('widget'=>'choice','model_timezone'=>'Europe/Berlin','input'=>'datetime'))
            ->add('endFirstTime','date')
            ->add('sendDay','choice', array('choices'=>(array(0=>'Jour J',1=>'J-1', 2=>'J-2', 3=>'J-3'))
                ,'required'=>true, 'multiple'=>false));
                                
//        
//        $ff=$builder->getFormFactory()
//        ;
//
//        $func= function (FormEvent $e) use ($ff){
//            $data= $e->getData();
//            $form= $e->getForm();
//            $choices=array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7');
//            if($data->getRecurrence()==true){
//                $choices=array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12',13=>'13',14=>'14',15=>'15');
//            }
//            if ($form->has('days')) {
//                $form->remove('days');
//            }
////            $form->add($ff->createNamed('days', 'choice', null, compact('choices')));
//
//        };
//        
//        $builder->addEventListener(FormEvents::PRE_SET_DATA, $func);
//        $builder->addEventListener(FormEvents::PRE_BIND, $func);
                
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
