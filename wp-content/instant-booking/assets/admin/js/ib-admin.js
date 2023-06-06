	/////////////////////////////////// Display options////////////////////////

window.addEventListener("load", function() {

	// store tabs variables
	var tabs = document.querySelectorAll("ul.nav-tabs > li");

	for (i = 0; i < tabs.length; i++) {
		tabs[i].addEventListener("click", switchTab);
	}

	function switchTab(event) {
		event.preventDefault();

		document.querySelector("ul.nav-tabs li.active").classList.remove("active");
		document.querySelector(".tab-pane.active").classList.remove("active");

		var clickedTab = event.currentTarget;
		var anchor = event.target;
		var activePaneID = anchor.getAttribute("href");

		clickedTab.classList.add("active");
		document.querySelector(activePaneID).classList.add("active");

	}

});

/////////////////////////////////// CRUD TAXES////////////////////////

jQuery(document).ready( function ( $ ){ 
		
	$('.ib_add_element').on( 'click' , function (){
		$('.ib_form_add').css("display","block");		
		$('.ib_form_update').css("display","none");		 
    });
	$('.annuler_update_taxe').on( 'click' , function (){
		$('.ib_form_update').css("display","none");		 
    });
	$('.annuler_taxe').on( 'click' , function (){
		$('.ib_form_add').css("display","none");		 
    });

	$('.ib_form_add').submit(function(e) {

		e.preventDefault();
		let data = {
		'action': 'ajaxadd_taxes',
		'nom_taxe': $('#nom_taxe').val(),
		'value_taxe': $('#value_taxe').val(),
		};
		
		jQuery.post(settingoption.ajaxurl,data,function(response){
			$('.ib_form_add').css("display", "none");
			
			if (response.code == 200) {    
				toastr.success('Taxe ajouté avec succès!');
					window.location.reload();
			}else if(response.code == 201){
				toastr.error('Cette taxes existe déja !');
			}else{
				toastr.error('Une erreur est survenue !');
			}

		});
	});

   $('.ib_update_taxe').on('click', function(e) {
		e.preventDefault();
		let data = {
		'action': 'ajaxupdate_taxes',
			'id_element': $(this).attr("data-id"),
	    };
		jQuery.post(settingoption.ajaxurl,data,function(response){
			$('.ib_form_update').css("display", "block");		
	    	$('.ib_form_add').css("display","none");	
			$('#n_taxe').val(response[0].nom);
			$('#v_taxe').val(response[0].price);
			$('.ib_form_id_taxes').val(response[0].id);
			
	   });
	   
	});

 
	$('.ib_form_update').submit(function(e) {

		e.preventDefault();
		let data = {
		'action': 'ajaxupdateall_taxes',
		'id_element': $('.ib_form_id_taxes').val(),	
		'n_taxe':$('#n_taxe').val(),
		'v_taxe':$('#v_taxe').val(),
	    };
		
		jQuery.post(settingoption.ajaxurl,data,function(response){
			$('.ib_form_update').css("display", "none");
			if(response.code == 200){
				toastr.success('Modification réussie !');
					window.location.reload(); 
			}else{
				toastr.error('Une erreur est survenue !');
			}
	   });
	});

	$('.ib_delete_taxe').on('click', function(e) {
		e.preventDefault();
		let data = {
		'action': 'ajaxDelete_taxes',
		'id_element': $(this).attr("data-id"),	
	    };
		jQuery.post(settingoption.ajaxurl,data,function(response){
			if(response.code == 200){
				toastr.success('Suppression réussie !');
					window.location.reload();
			}else{
				toastr.error('Une erreur est survenue !');
			}
	   });

	});
}); 
    /////////////////////////////////// CRUD COUPON ////////////////////////

jQuery(document).ready( function ( $ ){ 
		
	$('.ib_add_coupon').on( 'click' , function (){
		$('.ib_coupon_add').css("display","block");
		$('.ib_coupon_update').css("display","none");			 
    });
	$('.annuler_update_coupon').on( 'click' , function (){
		$('.ib_coupon_update').css("display","none");		 
    });
	$('.annuler_coupon').on( 'click' , function (){
		$('.ib_coupon_add').css("display","none");		 
    });
 
	$('.ib_coupon_add').submit(function(e) {
			e.preventDefault();

		let data = {
		'action': 'ajaxadd_coupons',
		'code_coupon': $('#code_coupon').val(),
		'date_coupon': $('#date_coupon').val(),
		'deduction_coupon': $('#deduction_coupon').val(),
		'remise_coupon': $('#remise_coupon option:selected').val(),
		'limitperson': $('#limitperson').val()
		};
		
		jQuery.post(settingoption.ajaxurl,data,function(response){
					
			$('.ib_coupon_add').css("display", "none");

			if(response.code == 200){
				toastr.success('Coupon ajouté avec succès!');
					window.location.reload();
			}else if(response.code == 201){
					toastr.error('Ce coupon existe déja !');
			}else{
				toastr.error('Une erreur est survenue !');
			}
		 
		});
	});

   $('.ib_update_coupon').on('click', function(e) {
		e.preventDefault();
		let data = {
		'action': 'ajaxupdate_coupons',
			'id_element': $(this).attr("data-id"),
	    };
		jQuery.post(settingoption.ajaxurl,data,function(response){
		
			$('.ib_coupon_update').css("display", "block");		
	    	$('.ib_coupon_add').css("display","none");
			$('#c_coupon').val(response[0].code);
			$('#d_coupon').val(response[0].date_fin);
			$('#de_coupon').val(response[0].prix_monaie);
			$('#re_coupon').val(response[0].prix_pourcentage);
			$('#l-person').val(response[0].limitPersonne);
			$('.ib_form_id_coupons').val(response[0].id);
		 
	   });
	   
	});

 
	$('.ib_coupon_update').submit(function(e) {

		e.preventDefault();
		let data = {
		'action': 'ajaxupdateall_coupons',
		'id_element': $('.ib_form_id_coupons').val(),	
		'c_coupon': $('#c_coupon').val(),
		'd_coupon': $('#d_coupon').val(),
		'de_coupon': $('#de_coupon').val(),
		're_coupon': $('#re_coupon option:selected').val(),
		'l-person': $('#l-person').val()
	    };

		jQuery.post(settingoption.ajaxurl,data,function(response){
			$('.ib_coupon_update').css("display", "none"); 
			if(response.code == 200){
				toastr.success('Modification réussie !');
					window.location.reload(); 
			}else{
				toastr.error('Une erreur est survenue !');
			}
	   });
	});

	$('.ib_delete_coupon').on('click', function(e) {
		e.preventDefault();
		let data = {
		'action': 'ajaxDelete_coupons',
		'id_element': $(this).attr("data-id"),	
	    };
		jQuery.post(settingoption.ajaxurl,data,function(response){
			if(response.code == 200){
				toastr.success('Suppression réussie !');
					window.location.reload();
			}else{
				toastr.error('Une erreur est survenue !');
			}

	   });

	});
}); 