

jQuery(document).ready(function($){

    window.operateEvent = {
        'click .ib_approuveBtn': function (e, value, row, index) {
            let data = {
                'action': 'ib_getBooking',
                'book_id': parseInt(row.id),
            };
           
            jQuery.post(ibactions.ajaxurl,data,function(response){
                console.log(response);
                if(response == 2){
                    Swal.fire({
                        title: 'Une réservation doit etre payé puis approuver?',
                        icon: 'warning',
                    })

                }else if( response == 8){

                    let data = {
                        'action': 'ib_cancelBooking',
                        'book_id':parseInt(row.id),
                    };
                    jQuery.post(ibactions.ajaxurl,data,function(response){
                        toastr.success('Modification prise en compte!');       
                            location.reload()     ;           
                    }) 

                }else{
                    toastr.error('Une erreur est survenue !');
                }
                
            }) 
            
         },
        'click .ib_annuleBtn': function (e, value, row, index) {
            Swal.fire({
                title: 'Voulez-vous Annuler cette réservation?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: ' OK !',
                cancelButtonText: 'Annuler',
            }).then((result) => {
                if (result.isConfirmed){ 
        
                    let data = {
                        'action': 'ib_cancelBooking',
                        'book_id':parseInt(row.id),
                    };
                    jQuery.post(ibactions.ajaxurl,data,function(response){
                        toastr.success('Modification prise en compte!');       
                            location.reload()
                        
                    }) 
                }
            });
         },
        'click .Ib_payement_book': function (e, value, row, index) {
            Swal.fire({
                title: 'Êtes vous sure que cette réservation a été payé?',
                text: "Vous ne pourrez plus revenir en arrière !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ok !',
                cancelButtonText: 'Annuler',
              }).then((result) => {
                if (result.isConfirmed) {
                    let data = {
                        'action': 'ib_buy_Booking',
                        'book_id':parseInt(row.id),
                    };
                    jQuery.post(ibactions.ajaxurl,data,function(response){
                        console.log(response);
                        if (response.code == 200) {  
                            toastr.success('Modification prise en compte!');                 
                                location.reload()
                        }else{
                            swal.fire("Une erreur est survenue !!!");
                        }
                    });
                }
              })
        },
            'click .ib_actionBtn': function (e, value, row, index) {
                Swal.fire({
                    title: 'Voulez-vous marquer la reservation complète  ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK!',
                    cancelButtonText: 'Annuler',
                  }).then((result) => {
                    if (result.isConfirmed) {
          
                        let data = {
                            'action': 'ib_completeBooking',
                            'book_id':$('.ib_actionBtn').children().val(),
                        };
                        jQuery.post(ibactions.ajaxurl,data,function(response){
                            if (response.code == 200) {
                                let data = {
                                    'action': 'ib_cancelBooking',
                                    'book_id':parseInt(row.id),
                                };
                                jQuery.post(ibactions.ajaxurl,data,function(response){
                                    toastr.success('Modification prise en compte!');       
                                        location.reload()
                                });
                            }else{
                                swal.fire("Une erreur est survenue !!!");
                            }
                            
                        });
                          
                    }
                  })
            },
      }


});
