
jQuery(window).ready(function ($) {

  separator = $('.ib_settings').attr('data-separate');
  decimal = $('.ib_settings').attr('data-decimal');

  $('[data-toggle="tooltip"]').tooltip();

  let instant_reservation = JSON.parse(localStorage.getItem("reservation"));
  njour = instant_reservation[0].numberDay;
  total = parseInt(instant_reservation[0].priceUnique) * njour;
  taxesTotal = (parseInt(instant_reservation[0].totalTaxes) * parseInt(instant_reservation[0].PriceTotal)) / 100;


  $('.ib_checkout_Total_price').text(taxesTotal.toFixed(parseInt(decimal)));
  $('.ib_checkout_unique_price').text(parseInt(instant_reservation[0].priceUnique).toFixed(parseInt(decimal)));
  $('.ib_checkout_unique_total').text(total.toFixed(parseInt(decimal)));
  $('.ib_checkout_service').val(instant_reservation[0].id);
  $('.ib_checkout_jour').text(instant_reservation[0].numberDay);
  $('.ib_checkout_title').text(instant_reservation[0].title);
  $('.ib_checkout_debut').text(instant_reservation[0].dateRetrait);
  $('.ib_checkout_fin').text(instant_reservation[0].dateRetour);
  $('.ib_checkout_depart').text(instant_reservation[0].depart);
  $('.ib_checkout_depot').text(instant_reservation[0].depot);
  $('.ib_checkout_service_id').text(instant_reservation[0].service_id);
  $('.ib_checkout_taxes_price').text(parseInt(instant_reservation[0].totalTaxes).toFixed(parseInt(decimal)));

  let data = {
    'action': 'ajaxget_extra_send',
    'id_reser': instant_reservation[0].ExtraTab,
    'njours': instant_reservation[0].numberDay,
  };

  jQuery.post(reservationFront.ajaxurl, data, function (response) {
    $('.ib_all_extra').append(response);
  });



});


jQuery(document).ready(function ($) {
  njours = 1;
  $('.ib_reserve_button').on('click', function () {

    var checkedValue = $('.ib_extra_list');
    const extraTab = [];
    checkedValue.each(function () {
      if ($(this).is(":checked")) {
        extraTab.push($(this).val());
      }
    });
    var check_in = myPicker.getStartDate().format('YYYY-MM-DD');
    var check_out = myPicker.getEndDate().format('YYYY-MM-DD');

    const lsContent = [];
    lsContent.push({
      id: $('.ib_input_content').val(),
      title: $('.ib_title').text(),
      dateRetrait: check_in,
      dateRetour: check_out,
      priceUnique: $('.ib_priceUni').val(),
      numberDay: njours,
      totalTaxes: $('.ib_input_taxes').val(),
      PriceTotal: $('.ib_grid_pricetotal').text(),
      depart: $('#pickselect').find(":selected").val(),
      depot: $('#dropselect').find(":selected").val(),
      ExtraTab: extraTab,
    });

    localStorage.setItem("reservation", JSON.stringify(lsContent));

  });


  // $('.needs_validation').submit(function(e) {
  //   e.preventDefault();
  //     let instant_reservation = JSON.parse(localStorage.getItem("reservation"));

  //     nbrejour = instant_reservation[0].numberDay;
  //     totalprice = parseInt(instant_reservation[0].priceUnique)*parseInt(nbrejour);
  //     taxesTotal = parseInt(instant_reservation[0].totalTaxes)+parseInt(instant_reservation[0].PriceTotal);

  //     let det = JSON.stringify(instant_reservation[0].ExtraTab) ;
  //     let data = {
  //         'action': 'ajaxServiceReservation',
  //         'first_name':$('#IB_firstName').val(),
  //         'last_name':$('#IB_lastName').val(),
  //         'address':$('#IB_address').val(),
  //         'email':$('#IB_email').val(),
  //         'telephone':$('#IB_telephone').val(),
  //         'pays':$('#IB_pays').val(),
  //         'ville':$('#IB_ville').val(),
  //         'code_postal':$('#IB_zip').val(),
  //       	'note':$('#IB_note').val(),
  //         'price_total':taxesTotal,
  //         'service_id':instant_reservation[0].id,
  //         'prix_base':totalprice,
  //         'start_date':instant_reservation[0].dateRetrait,
  //         'end_date':instant_reservation[0].dateRetour,
  //         'depart':instant_reservation[0].depart,
  //         'depot':instant_reservation[0].depot,
  //         'ExtraTab':det,
  //         'njours' : nbrejour,

  //      };

  //       jQuery.post(reservationFront.ajaxurl,data,function(response){

  //         if( response.code  == 200){
  //            Swal.fire(
  //             'Felicitaions ,Votre reservation est Enregistrer',
  //             'veuillez consulter vos mail pour la suite, vous pouvez nous contacter pour plus d\'informations',
  //             'success'
  //            )
  //            setTimeout(function () {
  //             e.currentTarget.submit();
  //           }, 3000);
  //         }else{
  //            Swal.fire(
  //             'Réservations echouer veillez changer de voiture!',
  //             'Echec'
  //            )
  //         }


  //         });
  // });

  /////////////////////calendar picker////////////////////
  separator = $('.ib_priceUni').attr('data-separate');
  decimal = $('.ib_priceUni').attr('data-decimal');

  $('.ib_extra_list').click(function () {
    priceExtra = parseInt($('.ib_grid_pricetotal').text());

    if ($(this).prop("checked")) {
      data = parseInt($(this).attr('data_calculate'));
      priceExtra = priceExtra + data * cpt;
      // $('.ib_grid_pricetotal').text(priceExtra); 
      priceExtra2 = priceExtra.toFixed(parseInt(decimal))
      $('.ib_grid_pricetotal').text(priceExtra2);
      // if( separator == "virgule-point" ){

      //  $('.ib_grid_pricetotal').text(priceExtra2.toLocaleString('en-US'));

      //  }else if(separator == "point-virgule"){

      //  $('.ib_grid_pricetotal').text(priceExtra2.toLocaleString('de-DE'));

      // }else if (separator == "espace-dot"){

      //   $('.ib_grid_pricetotal').text(priceExtra2.toLocaleString('en-US'));

      // }else{

      //   $('.ib_grid_pricetotal').text(priceExtra2.toLocaleString('en-US'));
      // }


    } else {
      var data = parseInt($(this).attr('data_calculate'));
      priceExtra = priceExtra - data * cpt;
      // $('.ib_grid_pricetotal').text(priceExtra);

      priceExtra2 = priceExtra.toFixed(parseInt(decimal))
      $('.ib_grid_pricetotal').text(priceExtra2);
    }
  });

  const myPicker = new Lightpick({
    field: document.getElementById('date_check_in'),
    secondField: document.getElementById('date_check_out'),
    numberOfMonths: 2,
    format: 'YYYY-MM-DD',
    autoclose: true,
    minDays: 3,
    minDate: moment(),
    onSelect: function (start, end) {
      if (end) {
        cpt = -(start.diff(end, 'days')) + 1;
        separator = $('.ib_priceUni').attr('data-separate');
        decimal = $('.ib_priceUni').attr('data-decimal');

        totalExtra = 0;
        njours = cpt;
        $('.ib_extra_list').each(function () {
          if ($(this).prop("checked")) {
            data = parseInt($(this).attr('data_calculate'));
            totalExtra = totalExtra + data * cpt;
          }
        });

        $('.ib_extra_price').each(function () {
          basicPrice = $(this).attr("basic-price");
          $(this).text(basicPrice * cpt);
        });

        initialPrice = parseInt($('.ib_grid_pricetotal').attr("initial-price"));
        total = initialPrice * cpt + totalExtra;
        // $('.ib_grid_pricetotal').text(total);
        total2 = total.toFixed(parseInt(decimal))
        $('.ib_grid_pricetotal').text(total2);
      }
    }

  });




});
