const STRIPE_PUBLISHABLE_KEY = document.currentScript.getAttribute('STRIPE_PUBLISHABLE_KEY');


jQuery(document).ready(function($) {
  

  var promo; 
  var taxesTotal; 
  let instant_reservation = JSON.parse(localStorage.getItem("reservation"));
  separator = $('.ib_settings').attr('data-separate');
  decimal  = $('.ib_settings').attr('data-decimal');
  nbrejour = instant_reservation[0].numberDay;
  totalprice = parseFloat(instant_reservation[0].priceUnique)*parseFloat(nbrejour);
  taxesTotal = ( parseInt(instant_reservation[0].totalTaxes) * parseInt(instant_reservation[0].PriceTotal))/100;
      

  $('#ib_reduction_code').submit(function(e) {
      
    e.preventDefault();
  
     let data = {
          'action': 'ajaxReductioncoupon',
          'code':$('#ib_promo_code').val(),      
       };
      
        jQuery.post(reservationFront.ajaxurl,data,function(response){
          payTotal = parseFloat(instant_reservation[0].totalTaxes)+parseFloat(instant_reservation[0].PriceTotal);
         
          promo  = response[0].code;
          deduction = response[0].prix_monaie;
          remise = response[0].prix_pourcentage;
          if(remise == "remise"){

            add = (payTotal*parseFloat(deduction))/100;
            payTotal = payTotal - ((payTotal*parseFloat(deduction))/100);
            taxesTotal = payTotal.toFixed(parseFloat(decimal));
            $('.ib_checkout_Total_price').text(payTotal.toFixed(parseFloat(decimal)));
            $('.ib_checkout_coupon').text(add.toFixed(parseFloat(decimal)));

          }else if(remise == "deduction" || remise == "" ) {

            payTotal = payTotal - parseFloat(deduction)
            taxesTotal = payTotal.toFixed(parseFloat(decimal));
            $('.ib_checkout_Total_price').text(payTotal.toFixed(parseFloat(decimal)));

            $('.ib_checkout_coupon').text(parseFloat(deduction).toFixed(parseFloat(decimal)));
          }else{
            toastr.error('Une erreur est survenue !');
          }
          });
  });

  if( STRIPE_PUBLISHABLE_KEY != 0){
    
   Stripe.setPublishableKey(STRIPE_PUBLISHABLE_KEY); 

    $('#ib_payement_form').submit(function(e) {

        e.preventDefault();
        // $('.ib_confirme_reservation').attr("disabled", "disabled");
         
        Stripe.createToken({
            number: $('#ib_cc_number').val(),
            cvc: $('#ib_cc_cvv').val(),
            exp_month: $('#ib_cc_expiration').val(),
            exp_year: $('#ib_year_expiration').val()
            
        }, function(status , response){
           
           if (response.error) {
                //enable the submit button
                $('.ib_confirme_reservation').removeAttr("disabled");
                //display the errors on the form
                $('#ib_payment_message').addClass("alert alert-danger d-flex align-items-center");
                $("#ib_payment_message").html(response.error.message);
            } else {

                let det = JSON.stringify(instant_reservation[0].ExtraTab) ;
                let data2 = {
                    'action': 'ajaxServiceReservation',
                    'first_name':$('#IB_firstName').val(),
                    'last_name':$('#IB_lastName').val(),
                    'address':$('#IB_address').val(),
                    'email':$('#IB_email').val(),
                    'telephone':$('#IB_telephone').val(),
                    'pays':$('#IB_pays').val(),
                    'ville':$('#IB_ville').val(),
                    'code_postal':$('#IB_zip').val(),
                     'note':$('#IB_note').val(),
                    'price_total':parseFloat(taxesTotal).toFixed(parseFloat(decimal)),
                    'service_id':instant_reservation[0].id,
                    'prix_base':parseFloat(totalprice).toFixed(parseFloat(decimal)), 
                    'start_date':instant_reservation[0].dateRetrait,
                    'end_date':instant_reservation[0].dateRetour,
                    'depart':instant_reservation[0].depart,
                    'depot':instant_reservation[0].depot,
                    'ExtraTab':det,
                    'njours' : nbrejour,
                    'id_promo': promo
                    }; 
                var token = response['id'];
              jQuery.post(reservationFront.ajaxurl,data2,function(respond){
                 
                console.log(respond);
                 name_ib = $('#IB_firstName').val() + " " + $('#IB_lastName').val();
                 let dataf = {
                    'action': 'ajaxstripepayement',
                    'token' : token,
                    'number': $('#ib_cc_number').val(),
                    'cvc': $('#ib_cc_cvv').val(),
                    'exp_month': $('#ib_cc_expiration').val(),
                    'exp_year': $('#ib_year_expiration').val(),
                    'name': name_ib,
                    'email':$('#IB_email').val(),
                    'price_total':parseFloat(taxesTotal).toFixed(parseFloat(decimal)),
                    'service_id':instant_reservation[0].id,
                    'book_id':respond.book_id,
                };
                
                  if( respond.code  == 200){
                
                    jQuery.post(ajaxstripe.ajaxurl,dataf,function(respondef){
                      console.log(respondef);
                        if( respondef == "succeeded"){
                         toastr.info('La transaction s\'est déroulée avec succès');
                  
                       }else if(respondef == "failed"){
                         toastr.warning('La transaction a échouée'); 
                         Swal.fire(
                           'Une erreur est survenue !, veuiilez nous contactrer pour finaliser votre réservation.',
                           'Echec'
                         );
                       }else{
                         toastr.error('Une erreur est survenue !');
                       }
                       
                     });

                    Swal.fire(
                      'Felicitaions ,Votre reservation est Enregistrer',
                      'veuillez consulter vos mail pour la suite, vous pouvez nous contacter pour plus d\'informations',
                      'success'
                      );
                      // setTimeout(function () {
                      //    e.currentTarget.submit();
                      //  }, 3000);
              
                  }else if( respond.code  == 220){
                     
                      Swal.fire(
                      'Réservation echoué',
                      'ce services vient d\'etre reservé',
                      'Echec'
                      );
                  }else{
                      Swal.fire(
                        'Réservation echoué veillez changer de service!',
                        'Echec'
                      );
                  }
                     
                });
                // formIb.get(0).submit();
            }
           }) 
        });
  }else{

    $('#ib_payement_form').submit(function(e) {

        e.preventDefault();
        $('.ib_confirme_reservation').attr("disabled", "disabled");
         
                let det = JSON.stringify(instant_reservation[0].ExtraTab) ;
                let data2 = {
                    'action': 'ajaxServiceReservation',
                    'first_name':$('#IB_firstName').val(),
                    'last_name':$('#IB_lastName').val(),
                    'address':$('#IB_address').val(),
                    'email':$('#IB_email').val(),
                    'telephone':$('#IB_telephone').val(),
                    'pays':$('#IB_pays').val(),
                    'ville':$('#IB_ville').val(),
                    'code_postal':$('#IB_zip').val(),
                     'note':$('#IB_note').val(),
                    'price_total':parseFloat(taxesTotal).toFixed(parseFloat(decimal)),
                    'service_id':instant_reservation[0].id,
                    'prix_base':parseFloat(totalprice).toFixed(parseFloat(decimal)), 
                    'start_date':instant_reservation[0].dateRetrait,
                    'end_date':instant_reservation[0].dateRetour,
                    'depart':instant_reservation[0].depart,
                    'depot':instant_reservation[0].depot,
                    'ExtraTab':det,
                    'njours' : nbrejour,
                    'id_promo': promo
                    };
                     
                
              jQuery.post(reservationFront.ajaxurl,data2,function(respond){
             
                console.log(respond);
                name_ib = $('#IB_firstName').val() + " " + $('#IB_lastName').val();

                  if( respond.code  == 200){
          
                    Swal.fire(
                      'Felicitaions ,Votre reservation est Enregistrer',
                      'veuillez consulter vos mail pour la suite, vous pouvez nous contacter pour plus d\'informations',
                      'success'
                      );
                      // setTimeout(function () {
                      //    e.currentTarget.submit();
                      //  }, 3000);
              
                  }else if( respond.code  == 220){
                    toastr.info('Veuillez sélectionner les articles reçues !');
                      Swal.fire(
                      'Réservation echoué',
                      'ce services a déja été reservé',
                      'Echec'
                      );
                  }else{
                      
                      $('.ib_confirme_reservation').removeAttr("disabled");
                      Swal.fire(
                        'Réservation echoué veillez changer de voiture!',
                        'Echec'
                      );
                  }
                     
                });
            });
  }


  
        
});
// jQuery(document).ready(function($) {
        
//     paypal.Buttons({
//         // Sets up the transaction when a payment button is clicked
//         createOrder: (data, actions) => {
//           return actions.order.create({
//             purchase_units: [{
//               amount: {
//                 value: '77.44' // Can also reference a variable or function
//               }
//             }]
//           });
//         },
//         // Finalize the transaction after payer approval
//         onApprove: (data, actions) => {
//           return actions.order.capture().then(function(orderData) {
//             // Successful capture! For dev/demo purposes:
//             console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
//             const transaction = orderData.purchase_units[0].payments.captures[0];
//             alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
//             // When ready to go live, remove the alert and show a success message within this page. For example:
//             // const element = document.getElementById('paypal-button-container');
//             // element.innerHTML = '<h3>Thank you for your payment!</h3>';
//             // Or go to another URL:  actions.redirect('thank_you.html');
//           });
//         }
//       }).render('#paypal-button-container');
          
//     });