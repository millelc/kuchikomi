/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    
function calculDateMessage(sendDay)
{
    var delai = sendDay.val()*1000*60*60*24;  
    var jour = $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_day').val();
    var mois = $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_month').val();
    var annee = $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_year').val();
    var date = new Date('"'+ annee +","+ mois + "," + jour + '"').getTime();
    var date2 = new Date(date - delai);            
    var today = new Date();
    date2.setHours(today.getHours()); 
    date2.setMinutes(today.getMinutes());
    date2.setSeconds(today.getSeconds());
    date2.setMilliseconds(today.getMilliseconds());       
    var thedate = date2.toLocaleDateString();
    var error = "Le jour d'envoi ne peut être antérieur à maintenant !";
    if(date2 < today)
    {
        return error;
            
    } else {    
        
        return thedate;
    }
}

function jourRecurrence(recurrence)
{
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
                indic = "à définir";
                break;
            }
        return indic;            
}
                 

    
$(document).ready(function(e) {

    var p = $('<p class="label label-default" style = "font-size:medium">' + calculDateMessage($('option:selected', this)) +
     '</p>').appendTo('.ici');
    var p2 = $('<p class="label label-default" style = "font-size:medium">' + jourRecurrence($('option:selected', this)) +
             '</p>').appendTo('.recurrence');
    p.hide();
    p2.hide();

    $('#obdo_kuchikomirestbundle_kuchikomirecurrent_sendDay').change(function(e)
    {
        p.show().text(calculDateMessage($('option:selected', this)));
        e.preventDefault();
    });              
    
    $('#obdo_kuchikomirestbundle_kuchikomirecurrent_sendDay').each(function(e){
    
    
        $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_day').change(function(){
               p.show().text(calculDateMessage($('option:selected', '#obdo_kuchikomirestbundle_kuchikomirecurrent_sendDay')));
            });
        $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_month').change(function(){
               p.show().text(calculDateMessage($('option:selected', '#obdo_kuchikomirestbundle_kuchikomirecurrent_sendDay')));
            });
        $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_year').change(function(){
               p.show().text(calculDateMessage($('option:selected', '#obdo_kuchikomirestbundle_kuchikomirecurrent_sendDay')));
            });
    });
    


     
     $('#obdo_kuchikomirestbundle_kuchikomirecurrent_recurrence').each(function(){
         
        $('#obdo_kuchikomirestbundle_kuchikomirecurrent_recurrence').change(function(){
            $('.recurrence').show();

            p2.hide();


            if($('option:selected', this).text() == 'Une seule fois')
            {   
                $('.finrecurrence').hide();  
                $('.recurrence').hide();

            } else 
            {
               p2.show().text(jourRecurrence($('option:selected', this)));
               $('.finrecurrence').show();
           }       
         });
         
         
         
        var envoi = jourRecurrence($('option:selected', '#obdo_kuchikomirestbundle_kuchikomirecurrent_recurrence'));
        
        $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_day').change(function(){     
           if(envoi !== 'à définir')
           {
                p2.show().text(jourRecurrence($('option:selected', '#obdo_kuchikomirestbundle_kuchikomirecurrent_recurrence')));   
           }
        });
        $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_month').change(function(){
            if(envoi !== 'à définir')
            {
                p2.show().text(jourRecurrence($('option:selected', '#obdo_kuchikomirestbundle_kuchikomirecurrent_recurrence')));
            }
           
        });
        $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_year').change(function()
        {
            if(envoi !== 'à définir')
            {
                p2.show().text(jourRecurrence($('option:selected', '#obdo_kuchikomirestbundle_kuchikomirecurrent_recurrence')));           
            }
        }); 
    });
     
    
    
    $('#kuchikomirecurrent').submit(function(e)
    {
        
        var today = new Date().toLocaleDateString(); 
        var firstSenDay = calculDateMessage($('option:selected', '#obdo_kuchikomirestbundle_kuchikomirecurrent_sendDay'));
       if(firstSenDay == today)
       {
          return confirm("Le message du "+ firstSenDay +" va être envoyé maintenant !");
           
       } 
       e.preventDefault();
    });
    
e.preventDefault();
});
   

    
    

   