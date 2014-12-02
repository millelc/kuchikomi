/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    
    function calculDateMessage(n){
    var delai = n.val()*1000*60*60*24;  
    var jour = $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_day').val();
    var mois = $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_month').val();
    var annee = $('#obdo_kuchikomirestbundle_kuchikomirecurrent_beginRecurrence_year').val();
    var date = new Date('"'+ annee +","+ mois + "," + jour + '"').getTime();
    var date2 = new Date(date - delai);    
    var thedate = 'Le ' + date2.toLocaleDateString();    
    var today = new Date();
    today.setHours(12);    
    var error = "Le jour d'envoi ne peut être antérieur ou égal au jour du début du message 12H !";
    if(date2 <= today)
    {
        return error;
        
    } else {
        
        return thedate;
    }
}

    
$(document).ready(function(e) {

     var p = $('<p class="label label-default" style = "font-size:medium">' + calculDateMessage($('option:selected', this)) +'</p>').appendTo('.ici');
     p.hide();

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
              

    if($('option:selected', this).text() == 'Une seule fois')
    {
        $('.recurrence').hide();            
    } else 
    {
        $('.recurrence').show();
    }
        
    
    });
    e.preventDefault();
 });
    
    

   