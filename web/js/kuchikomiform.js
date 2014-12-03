/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    
    function calculDateMessage(sendDay){
    var delai = sendDay.val()*1000*60*60*24;  
    var jour = $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_day').val();
    var mois = $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_month').val();
    var annee = $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_year').val();
    var date = new Date('"'+ annee +","+ mois + "," + jour + '"').getTime();
    var date2 = new Date(date - delai);    
    var thedate = "Le " + date2.toLocaleDateString();    
    var today = new Date();
    date2.setHours(12); 
    date2.setMinutes(0);
    var error = "Le jour d'envoi ne peut être antérieur ou égal au jour du début du message 12H !";
    if(date2 <= today)
    {
        return error;
        
    } else {
        
        return thedate;
    }
}

    function jourRecurrence(recurrence){
        var indic;
        var jour = $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_day').val();
        var mois = $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_month').val();
        var annee = $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_year').val();
        var date = new Date('"'+ annee +","+ mois + "," + jour + '"');
        var weekday = new Array(7);
        weekday[0] = "Dimanche";
        weekday[1]=  "Lundi";
        weekday[2] = "Mardi";
        weekday[3] = "Mercredi";
        weekday[4] = "Jeudi";
        weekday[5] = "Vendredi";        
        weekday[6] = "Samedi";

        switch (recurrence.text()) {
            case "Chaque semaine" :
                indic =  "Chaque " + weekday[date.getDay()] ;
                break;
            case "Chaque mois" :    
                indic = "Chaque " + jour + " du mois";
                break;
            case "Chaque année" :
                indic = "Chaque "+ jour + "/" + mois;
                break;
            default :
                indic = "";
            }
        return indic;            
    }
                
    

    
$(document).ready(function(e) {

     var p = $('<p class="label label-default" style = "font-size:medium">' + calculDateMessage($('option:selected', this)) +'</p>').appendTo('.ici');
     var p2 = $('<p class="label label-default" style = "font-size:medium">' + jourRecurrence($('option:selected', this)) +'</p>').appendTo('.recurrence');
     p.hide();
     p2.hide();

    $('#obdo_kuchikomirestbundle_kuchikomirecurrent_sendDay').change(function(){

        p.show().text(calculDateMessage($('option:selected', this)));

       });              
    
    $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_day').change(function(e){
       p.show().text(calculDateMessage($('option:selected', '#obdo_kuchikomirestbundle_kuchikomirecurrent_sendDay')));
    });
    $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_month').change(function(e){
       p.show().text(calculDateMessage($('option:selected', '#obdo_kuchikomirestbundle_kuchikomirecurrent_sendDay')));
    });
    $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_year').change(function(e){
       p.show().text(calculDateMessage($('option:selected', '#obdo_kuchikomirestbundle_kuchikomirecurrent_sendDay')));
    });
        

    $('#obdo_kuchikomirestbundle_kuchikomirecurrent_recurrence').change(function(e){
              
    var recurSelect = $('option:selected', this);
    p2.show().text(jourRecurrence(recurSelect));
     
    
    $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_day').change(function(e){
       p2.show().text(jourRecurrence(recurSelect));
    });
    $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_month').change(function(e){
       p2.show().text(jourRecurrence(recurSelect));
    });
    $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_year').change(function(e){
       p2.show().text(jourRecurrence(recurSelect));
    });
    });
    e.preventDefault();
 });
    
    

   