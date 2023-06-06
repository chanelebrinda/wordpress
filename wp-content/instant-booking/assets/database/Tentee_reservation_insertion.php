<?php

function randomAbc123(){
	$characts    = 'abcdefghijklmnopqrstuvwxyz';
        $characts   .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';	
	$characts   .= '1234567890'; 
	$code_aleatoire      = ''; 

	for($i=0;$i < 4;$i++)
	{ 
        $code_aleatoire .= substr($characts,rand()%(strlen($characts)),1); 
	}
return $code_aleatoire; 
}

function tentee_reservation_insert_reservation($id_s,$id_c,$prixB,$extra,$prixT,$dateD,$dateF,$depart,$depot,$jours) {
	global $wpdb;
	$date = date('y-m-d h:i:s');
	$numero_commande = 'IB_'.date('ymd').randomAbc123();
	$sql = "INSERT INTO IB_tentee_reservation (id_service,id_client,prix_base,extra,prix_Total,date_debut,date_fin,created_on,depart,depot,numero_commande,jours) VALUES ($id_s,$id_c,$prixB,'$extra',$prixT,'$dateD','$dateF','$date','$depart','$depot','$numero_commande','$jours')";
	$result = $wpdb->get_results ($sql);
	return true; // display data
}
   

function tentee_reservation_select_reservation($id_r) {
	global $wpdb;

	$result = $wpdb->get_results ("SELECT * FROM IB_tentee_reservation WHERE id = $id_r");

	return $result; // display data
	
}

function tentee_reservation_select_client_reservation($id_r) {
	global $wpdb;

	$result = $wpdb->get_results ("SELECT id_client FROM IB_tentee_reservation WHERE id = $id_r");

	return $result; // display data
	
}
function IB_select_id_client($id_c) {
	global $wpdb;
	$result = $wpdb->get_var("SELECT id FROM IB_tentee_reservation WHERE id_client = $id_c ORDER BY ID DESC LIMIT 1");

	return $result; // display data
	
}
function tentee_reservation_inseetDate_reservation($date, $id_r) {
	global $wpdb;

	$result = $wpdb->get_results ("UPDATE IB_tentee_reservation SET date_on= $date WHERE id_reservation = $id_r;");

	return $result; // display data
	
}

function tentee_reservation_select_all() {
	global $wpdb;

	$sql = "SELECT * FROM IB_tentee_reservation ORDER BY id DESC";

	$result = $wpdb->get_results ($sql );

	return $result;
}


function tentee_reservation_insert_creanaux($id_e, $crenaux) {
	global $wpdb;
	$sql = "INSERT INTO IB_crenaux_horaire (id_event,crenaux) VALUES ($id_e,'$crenaux')";
	$result = $wpdb->get_results ($sql);
	return $result; // display data
}

function tentee_reservation_select_id_creanaux($id_e) {
	global $wpdb;
	$sql = "SELECT * FROM IB_crenaux_horaire WHERE id_event = $id_e" ;
	$result = $wpdb->get_results ($sql);
	return $result; // display data
}
function tentee_reservation_update_creanaux($id_e,$crenaux) {
	global $wpdb;
    $sql = "UPDATE IB_crenaux_horaire SET crenaux = '$crenaux' WHERE id_event = $id_e";
	$result = $wpdb->get_results ($sql);
	return $result; 
	
}
function tentee_reservation_select_creanaux($id_e) {
	global $wpdb;
	$sql = "SELECT crenaux FROM IB_crenaux_horaire WHERE id_event = $id_e" ;
	$result = $wpdb->get_results ($sql);
	return $result; // display data
}
function Instant_booking_approuve_reservation($etat, $id_r) {
	global $wpdb;

	$result = $wpdb->get_results ("UPDATE IB_tentee_reservation SET etat= $etat WHERE id= $id_r;");

	return true; // display data
	
}
function Instant_booking_status_reservation($status, $id_r) {
	global $wpdb;
    
	$result = $wpdb->get_results ("UPDATE IB_tentee_reservation SET status_payement= $status WHERE id= $id_r;");

	return true; // display data
	
}

/************************historique****************/

function tentee_reservation_historique($id_em,$id_e,$actions,$type_r) {
	global $wpdb;
	$created_on = date('y-m-d h:i:s');
	$sql = "INSERT INTO IB_tentee_historique (id_employe,id_element,actions,type_r,created_on) VALUES ($id_em,$id_e,'$actions','$type_r','$created_on')";
			$result = $wpdb->get_results($sql);
	return $result; // display data
}

function tentee_reservation_historique_select() {
	global $wpdb;
	$sql = "SELECT * FROM ib_tentee_historique";
	$result = $wpdb->get_results ($sql);
	return $result; // display data
}

function tentee_reservation_count() {
	global $wpdb;
	$sql = "SELECT count(*) FROM IB_tentee_reservation";
	$result = $wpdb->get_var ($wpdb->prepare( $sql));
	return $result; 
}
function tentee_reservation_count_client() {
	global $wpdb;
	$sql = "SELECT count(*) FROM IB_tentee_reservation";
	$result = $wpdb->get_var ($wpdb->prepare( $sql));
	return $result; 
}

function tentee_reservation_count_etat($etat) {
	global $wpdb;
	$sql = "SELECT count(*) FROM IB_tentee_reservation WHERE etat = $etat";
	$result = $wpdb->get_var ($wpdb->prepare( $sql));
	return $result; 
}
function tentee_reservation_count_statut($statut) {
	global $wpdb;
	$sql = "SELECT count(*) FROM IB_tentee_reservation WHERE status_payement = $statut";
	$result = $wpdb->get_var ($wpdb->prepare( $sql));
	return $result; 
}
function tentee_reservation_En_cours() {
	global $wpdb;
	$created_on =  date('Y-m-d');
	$sql = "SELECT * FROM IB_tentee_reservation WHERE '$created_on' >= date_debut and date_fin >= '$created_on'";
	$result = $wpdb->get_results ($wpdb->prepare( $sql));
	return $result; // display data
}
function tentee_reservation_paye($id) {
	global $wpdb;
	$sql = "SELECT status_payement FROM IB_tentee_reservation WHERE id = $id";
	$result = $wpdb->get_var($sql);
	return $result; // display data
}

function tentee_taxe_insert($nom,$price) {
	global $wpdb;
	$sql = "INSERT INTO ib_tentee_taxe(nom,price) VALUES ('$nom','$price')";
	$result = $wpdb->get_results($sql);
	return true; // display data
}
function tentee_taxe_select_all() {
	global $wpdb;
	$sql = "SELECT * FROM ib_tentee_taxe ";
	$result = $wpdb->get_results($sql);
	return $result; // display data
}
function tentee_taxe_select_id($id) {
	global $wpdb;
	$sql = "SELECT * FROM ib_tentee_taxe WHERE id = $id ";
	$result = $wpdb->get_results($sql);
	return $result; // display data
}
function tentee_taxe_select_nom($nom) {
	global $wpdb;
	$sql = "SELECT * FROM ib_tentee_taxe WHERE nom ='$nom' ";
	$result = $wpdb->get_results($sql);
	return $result; // display data
}
function tentee_taxe_update($id,$nom,$price) {
	global $wpdb;
	$sql = "UPDATE ib_tentee_taxe SET nom ='$nom', price = '$price' WHERE id = $id ";
	$result = $wpdb->get_results($sql);
	return true; // display data
}
function tentee_taxe_delete($id) {
	global $wpdb;
	$sql = "DELETE FROM ib_tentee_taxe WHERE id = $id ";
	$result = $wpdb->get_results($sql);
	return true; // display data
}
function tentee_reservation_search_date($date_out) {
	global $wpdb;
	$sql = "SELECT ID FROM wp_posts WHERE post_type ='service' AND post_status = 'publish' AND ID 
	NOT IN (SELECT id_service FROM ib_tentee_reservation) OR ID IN (SELECT id_service FROM ib_tentee_reservation WHERE date_fin <= '$date_out')";
	$result = $wpdb->get_results($sql);
	return $result; // display data
}
function tentee_reservation_search_date_inout($start ,$end) {
	global $wpdb;
	$sql = "SELECT ID FROM wp_posts WHERE post_type ='service' AND post_status = 'publish' AND
	 ID NOT IN (SELECT id_service FROM ib_tentee_reservation WHERE (date_debut > '$start' AND date_debut < '$end') OR 
	(date_fin > '$start' AND date_fin < '$end') OR (date_debut < '$start' AND date_fin > '$end'));" ;
	$result = $wpdb->get_results($sql);
	return $result; // display data
}


function tentee_reservation_select_date_select( $start ,$end ) {
	global $wpdb;
	$sql = "SELECT id_service FROM ib_tentee_reservation WHERE date_debut = '$start' AND date_fin = '$end'";
	$result = $wpdb->get_results($sql);
	return $result; // display data
}

function tentee_coupon_insert($code,$prix_monaie,$prix_pourcentage,$limitPersonne,$date_fin) {
	global $wpdb;
	$sql = "INSERT INTO ib_tentee_coupon(code,prix_monaie,prix_pourcentage,limitPersonne,date_fin) VALUES ('$code','$prix_monaie','$prix_pourcentage',$limitPersonne,'$date_fin')";
	$result = $wpdb->get_results($sql);
	return true; // display data
}
function tentee_coupon_select_all() {
	global $wpdb;
	$sql = "SELECT * FROM ib_tentee_coupon ";
	$result = $wpdb->get_results($sql);
	return $result; // display data
}
function tentee_coupon_select_id($id) {
	global $wpdb;
	$sql = "SELECT * FROM ib_tentee_coupon WHERE id = $id ";
	$result = $wpdb->get_results($sql);
	return $result; // display data
}
function tentee_coupon_select_code($code) {
	global $wpdb;
	$sql = "SELECT * FROM ib_tentee_coupon WHERE code = '$code' ";
	$result = $wpdb->get_results($sql);
	return $result; // display data
}
function tentee_coupon_update($id,$code,$prix_monaie,$prix_pourcentage,$limitPersonne,$date_fin) {
	global $wpdb;
	$sql = "UPDATE ib_tentee_coupon SET code ='$code', prix_monaie = '$prix_monaie', prix_pourcentage ='$prix_pourcentage' , limitPersonne = '$limitPersonne' , date_fin = '$date_fin' WHERE id = $id ";
	$result = $wpdb->get_results($sql);
	return true; // display data
}
function tentee_coupon_get_limit($id) {
	global $wpdb;
	$sql = "SELECT maxparPersonne FROM ib_tentee_coupon WHERE id = '$id' ";
	$result = $wpdb->get_var($sql);
	return $result; // display data
}
function tentee_coupon_update_limit($id,$nbr_send) {
	global $wpdb;
	$sql = "UPDATE ib_tentee_coupon SET maxparPersonne ='$nbr_send' WHERE id = $id ";
	$result = $wpdb->get_results($sql);
	return true; // display data
}
function tentee_coupon_delete($id) {
	global $wpdb;
	$sql = "DELETE FROM ib_tentee_coupon WHERE id = $id ";
	$result = $wpdb->get_results($sql);
	return true; // display data
}


function tentee_payement($card_service_id,$name,$email,$itemPrice,$amount,$due_amount,$payment_method,$deduction,$status,$date) {
	global $wpdb;
	$sql = "INSERT INTO ib_tentee_payement(id_booking,name_c,email,total_item,paid_amount,
    due_amount,payment_method,Deduction,payment_status,created_at)VALUES 
	('$card_service_id','$name','$email','$itemPrice','$amount','$due_amount','$payment_method','$deduction','$status','$date')";
	$result = $wpdb->get_results($sql);
	return $result; // display data
}