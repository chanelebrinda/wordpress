<?php
get_the_terms('service','extra');

// if (!empty($_GET['page']) && strpos($_GET['page'], 'Tentee_') !== false) {
//     echo"sucess";
// }else{
//     echo "echec";
// }
    ?>

    

    <!-- Button trigger modal -->

<!-- Modal -->
        <div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeeModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                    
                    <div class="form-group col-md-6">
                        <label for="firstname" class="form-label"><?php _e( 'Nom', 'instant_booking' ); ?></label>
                        <input type="text" class="col-10" id="ibfname"  name="ibfname" >
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="website" class="form-label"><?php _e( 'Prenom', 'instant_booking' ); ?></label>
                        <input type="text" class="col-10"  id="iblname"  name="iblname">
                    </div>

                
                    <div class="form-group col-md-6">
                        <label for="username" class="form-label"><?php _e( 'Nom d\'utrilisateur', 'instant_booking' ); ?></label>
                        <input type="text" class="col-10" id="ibusername" name="ibusername">
                    </div>

                    <div class="form-group col-md-6" >
                        <label for="email" class="form-label"> <?php _e( 'Email' , 'instant_booking'); ?></label>
                        <input type="text" class="col-10" id="ibemail" name="ibemail" >
                    </div>
                
                    <div class="form-group col-md-6">
                        <label for="telephone" class="form-label"><?php _e( 'Telephone', 'instant_booking' ); ?></label>
                        <input type="text" class="col-10" id="ibtelephone" name="ibtelephone">
                    </div>
                
                    <div class="form-group col-md-6">
                        <label for="bio" class="form-label" ><?php _e( ' Bio' , 'instant_booking'); ?></label>
                        <textarea name="ibbio" id="ibbio" rows="3" ></textarea>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" id ="submit_employer" class="btn ib_primary_button" data-dismiss="modal"><?php _e( 'Envoyer' , 'instant_booking'); ?></button>
                <button type="button" id ="forget_employer" class="btn btn-secondary" data-dismiss="modal"><?php _e( 'annuler' , 'instant_booking'); ?></button>
            </div>
            </div>
        </div>
        </div>

    <div class="ib-page-header content-wrapper" id="ib-section">
        <div class="d-flex flex-row  align-items-center  justify-content-between">
          <div class="d-flex flex-row  align-items-center border-end  ib-part1">
            <div class="ib-logo">
                <img width="100" src="<?php echo $logoInstant;?>" class="logo-big"> 
            </div> 
            <H4>Instant Booking</H4>
          </div> 
            <div class="d-flex">
                <button type="button" class=" btn ib_primary_button" data-toggle="modal" data-target="#employeeModal">
                  <span><i class="fas fa-plus"></i>Ajouter un Employé</span>
               </button>
            </div>
        </div>
        <hr>
        <?php

    ?>

<div class="employe_container">
    <div class="ib-employee row" id="ib_employee_container">   
        <?php 
            $argsEmployee = array(
                'role' => 'Employé',
                'orderby' => 'user_nicename',
                'order' => 'ASC'
            );
            $users = get_users($argsEmployee);
            
            foreach($users as $employee){
                $users_last_name = get_user_meta( $employee->ID , 'last_name', true);
                $users_first_name = get_user_meta( $employee->ID , 'first_name', true);
                $users_phone = get_user_meta( $employee->ID , 'user_phone', true);
            
                ?>
                <div class=" col-xl-4 col-md-6 col-xs-12">
                    <div class="Ib-employe-unique " >
                    <a href="" class="employelink" value="<?php echo esc_html($employee->ID) ?>">
                        <div class="ib_employer_card">
                            <div class="circle_image"><img src="<?php echo $blankPicture;?>"></div>
                            <div class="ib_employe_details">
                                <span><?php echo esc_html( ucfirst($users_first_name) .' '.  ucfirst($users_last_name)) ?></span>
                                <span> <?php echo esc_html($employee->user_email) ;?></span>
                                <span><?php echo esc_html($users_phone) ?></span>
                            </div>
                        </div>
                        
                    </a>
                    </div>

                </div>
            
                <?php
            }       
                   
        ?>
    </div> 
    </div>

    <div class="modal fade" id="UpdateEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalUpdate" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="employeeModalUpdate">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">
            
            <div class="form-group col-md-6">
                <label for="firstname" class="form-label"><?php _e( 'Nom', 'instant_booking' ); ?></label>
                <input type="text" class="col-10" id="ib_e_fname"  name="ib_e_fname" >
            </div>
            
            <div class="form-group col-md-6">
                <label for="website" class="form-label"><?php _e( 'Prenom', 'instant_booking' ); ?></label>
                <input type="text" class="col-10"  id="ib_e_lname"  name="ib_e_lname">
            </div>

          
            <div class="form-group col-md-6">
                <label for="username" class="form-label"><?php _e( 'Nom d\'utrilisateur', 'instant_booking' ); ?></label>
                <input type="text" class="col-10" id="ib_e_username" name="ib_e_username">
            </div>

            <div class="form-group col-md-6" >
                <label for="email" class="form-label"> <?php _e( 'Email', 'instant_booking' ); ?></label>
                <input type="text" class="col-10" id="ib_e_email" name="ib_e_email" >
            </div>
          
            <div class="form-group col-md-6">
                <label for="telephone" class="form-label"><?php _e( 'Telephone' , 'instant_booking'); ?></label>
                <input type="text" class="col-10" id="ib_e_telephone" name="ib_e_telephone">
            </div>
        
            <div class="form-group col-md-6">
                <label for="bio" class="form-label" ><?php _e( ' Bio', 'instant_booking' ); ?></label>
                <textarea name="ib_e_bio" id="ib_e_bio" rows="3" ></textarea>
            </div>
          
            <input type="hidden" id="ib_e_ID" value="">

      </div>
      <div class="modal-footer">
        <button type="button" id="update_employer" class="btn ib_primary_button" ><?php _e( 'Envoyer' , 'instant_booking'); ?></button>
        <button type="button" id="Delete_employer" class="btn btn-danger" ><?php _e( 'Supprimer', 'instant_booking' ); ?></button>
        <button type="button" class="btn btn-secondary forget_employer"><?php _e( 'annuler', 'instant_booking' ); ?></button>
      </div>
    </div>
  </div>
</div>

    </div>

<?php

?>

