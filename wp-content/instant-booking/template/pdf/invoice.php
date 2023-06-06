<!DOCTYPE html>
<html lang="en" xmlns="http:www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width,initial-scale=1">
 <meta name="x-apple-disable-message-reformatting">
 <title></title>
 <!--[if mso]>
 <noscript>
   <xml>
     <o:OfficeDocumentSettings>
       <o:PixelsPerInch>96</o:PixelsPerInch>
     </o:OfficeDocumentSettings>
   </xml>
 </noscript>
 <![endif]-->
</head>
<body style="">


 <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
   <tr>
     <td align="center" style="padding:0;">
        <table role="presentation" style="width:100%;border-collapse:collapse;border-spacing:0;text-align:left;">
          <tbody >
             <tr>
               <td style="font-size: 16px; margin: 0; padding:0 16px;">
                 <div style="">
                   <p align="center" style="font-size: 26px; padding:16px; 0">Numéro De Commande :<?php echo $num_facture ?></p>
                 </div>
                 <div style="display: flex ;justify-content: space-between; paddind:0px 20px ;color: #626262;font-size: 18px">
                   <div style="display: flex; flex-direction: column;">
                     <span style="color: #0080d3; padding-bottom: 5px"><?php echo strtoupper($client_nom .' '. $client_prenom) ?></span>
                     <span style="padding-bottom: 5px"><?php echo ucwords($client_adr) ?></span>
                     <span style="padding-bottom: 5px"><?php echo $client_tel?></span>
                   </div>
                   <div style="display: flex; flex-direction: column">
                     <span style="padding-bottom: 5px">Status: 
                        <?php if($status == "2"){?>
                         <strong style="color: #28a745;">Impayé</strong>
                        <?php }else if($status == "8"){?>
                         <strong style="color: #28a745;">Payé</strong>    <?php } ?>
                     </span>
                     <span style="padding-bottom: 5px"><?php echo $created ?></span>
                   </div>
                 </div>

                 <div style="display: flex ;justify-content: space-around;height:70px;margin: 15px 0; padding:20px ;color: #2c2c2c;font-size: 18px;background-color: #f0f0f0;">
                   <div style="display: flex; flex-direction: column;">
                     <span style="font-weight: 600">Date Départ </span>
                     <span><?php echo $date_debut?></span>
                   </div>
                   <div style="display: flex; flex-direction: column;">
                     <span style="font-weight: 600">Date retour </span>
                     <span><?php echo $date_fin ?></span>
                   </div>
                 </div>

                 <div style="padding: 20px 30px"></div> 
                 <table style="width: 100%;border-collapse: collapse;border: 1px solid #ddd;">
                   <tbody>

                     <tr align="left">
                     <div class="table-responsive">
                           <table style="padding: 8px;width: 100%">
                               <thead style="background-color: #0080d3;text-align: left">
                                   <tr class="">
                                       <th style=" padding: 8px;">Description</th>
                                       <th style=" padding: 8px;">Prix par jour</th>
                                       <th style=" padding: 8px;">prix total</th>
                                   </tr>
                               </thead>
           
                               <tbody class="background-color: #0080d3">
                                   <tr></tr>
                                   <tr>
                                       <td style=" padding: 8px;"><?php echo ucwords($title) ?> </td>
                                       <td style=" padding: 8px;"><?php echo $prix_unique.''. $devise ?> </td>
                                       <td style=" padding: 8px;"><?php echo $prix_unique.''. $devise ?> </td>
                                   </tr> 
                                   <?php
                                   foreach($extras as $extra){?>
                                   <tr style="border-top: 1px solid #b8b8b8;">
                                     <td style=" padding: 8px;"><?php echo ucwords(get_term_by( 'term_id',$extra,'extra')->name) ?></td>
                                     <td style=" padding: 8px; "></td>
                                     <td style=" padding: 8px;"><?php echo esc_html(get_term_meta( $extra, 'extraPrice',true)).''. $devise ?></td>
                                   </tr>
                                   <?php } ?>
                                  
                               </tbody>
                           </table>
                       </div>
                     </tr>

                   </tbody>
                 </table>
                 <div style="display: flex;padding: 20px 50px 20px 20px;color: #626262;font-size: 16px;">
                   <div style="flex; width: 60%">
                        
                   </div>

                   <div style="display: flex;flex-direction: column; width: 40%">
                       <div style="display: flex;flex-direction: row; justify-content: space-between; padding: 5px 0">
                           <div style="">
                               NET A Payer
                           </div>
                           <div style="">
                               <span style="text-120 text-secondary-d1"><?php  echo esc_html($prix_total .''. $devise) ?></span>
                           </div>
                       </div>

                       <div style="display: flex;flex-direction: row; justify-content: space-between; padding: 5px 0">
                           <div style="">
                               Tax (0%)
                           </div>
                           <div style="">
                               <span style="text-110 text-secondary-d1"></span>
                           </div>
                       </div>

                       <div style="display: flex;flex-direction: row; justify-content: space-between; padding: 5px 0; font-size: 20px ; font-weight: 600">
                           <div style="">
                               Somme Total
                           </div>
                           <div style="">
                               <span style="color: #0080d3;"><?php echo esc_html($prix_total .''. $devise) ?></span>
                           </div>
                       </div>
                   </div>
                 </div>
             
               </td>
             </tr>
          </tbody>
        </table>
     </td>
  </tr>
 </table>
    
</body>
</html> 
