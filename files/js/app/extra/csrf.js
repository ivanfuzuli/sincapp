define(['jquery'], function($){
   return{
       init: function(){
					$.ajaxSetup({
					  headers: {
					    'X-CSRF-Token': _token
					  }
					});
       }
   }
});