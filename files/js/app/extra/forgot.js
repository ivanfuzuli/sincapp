define(['jquery', 'bootstrap'], function($){
   return{
       init: function(){
        $('#pass-change-form').submit(function(){
            $('input[type=submit]', this).attr('disabled', 'disabled');            
        });           
       }
   } 
});
