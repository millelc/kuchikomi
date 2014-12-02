<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace obdo\ServicesBundle\Services\Constraints;

use Symfony\Component\Validator\Constraint;
       

/**
 * 
 *
 * @Annotation
 * 
 */
class DateRange extends Constraint {
    
    public $message ="La date de fin de l'évenement ne peut pas être égale ou antérieure à la date de début !";
    public $messageRecurrent = "La date de fin de répétition ne peut pas être égale ou antérieure à la date de début !";
    public $messageHeure = "L'heure de l'évènement ne peut pas être égale où antérieure à l'heure de début !";
    
    public function getTargets() {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy() {
        return 'daterange_validator';
    }



}
