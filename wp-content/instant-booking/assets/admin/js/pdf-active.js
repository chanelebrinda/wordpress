(function ($) {
 "use strict";

		$('a.media').media({width:630, height:950});
		 
 
})(jQuery); 

///datableactive
(function ($) {
	"use strict";
   
	   var $table = $('#table');
		   $('#toolbar').find('select').change(function () {
			 $table.bootstrapTable('destroy').bootstrapTable({
			   exportDataType: $(this).val()
			 });
		   });
	
   })(jQuery); 