<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace obdo\ServicesBundle\Services\Constraints;

use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
use obdo\KuchiKomiRESTBundle\Entity\KuchiKomiRecurrent;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
/**
 * Description of DateRangeValidator
 *
 * @author emilie
 */
class DateRangeValidator extends ConstraintValidator {
   
    
    
        public function validate($entity, Constraint $constraint)
                
    {
        if($entity instanceof KuchiKomi){
                  
            if ($entity->getTimestampBegin() >= $entity->getTimestampEnd()) {                
                $this->context->addViolation($constraint->message);
            }            

        }        
        if ($entity instanceof KuchiKomiRecurrent){
            if ($entity->getBeginRecurrence() >= $entity->getEndRecurrence()) {
                if($entity->getRecurrence()!='unique'){
                     $this->context->addViolation($constraint->messageRecurrent);
                }
            }

            if($entity->getBeginRecurrence() > $entity->getEndFirstTime()){
                $this->context->addViolation($constraint->message);
            }
            if($entity->getBeginRecurrence() == $entity->getEndFirstTime()){
                if($entity->getBeginTime()>= $entity->getEndTime()){
                        $this->context->addViolation($constraint->messageHeure);
                }
            }
            
            return true;

        }
    }
}
