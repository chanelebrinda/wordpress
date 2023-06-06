<?php  

global $jal_db_version;
$jal_db_version = '1.0';

function tentee_reservation(){
   global $wpdb;
   global $jal_db_version;

   $charset_collate = $wpdb->get_charset_collate();

   $sql = "CREATE TABLE IB_tentee_reservation (
       id int(10) unsigned NOT NULL AUTO_INCREMENT,
       id_service int(10) NOT NULL,
       extra text DEFAULT '' NOT NULL,
       id_event int(10) NOT NULL DEFAULT'000',
       id_client int(10) NOT NULL,
       etat int(10) DEFAULT 0 NOT NULL,
       status_payement int(10) DEFAULT 2 NOT NULL,
       type_r varchar(100) DEFAULT 'service' NOT NULL,
       depart varchar(100) DEFAULT '' NOT NULL,
       depot varchar(100) DEFAULT '' NOT NULL,
       prix_base bigint(30) NOT NULL,
       prix_Total bigint(10) NOT NULL,
       jours int(10) NOT NULL,
       numero_commande varchar(40) ,
       date_debut date DEFAULT '2022-01-01' NOT NULL, 
       date_fin date DEFAULT '2022-01-01' NOT NULL, 
       heure_debut time DEFAULT '00:00:00' NOT NULL, 
       heure_fin time DEFAULT '00:00:00' NOT NULL,
       created_on datetime DEFAULT '2022-01-01 00:00:00' NOT NULL,
       modified_on datetime DEFAULT '2022-01-01 00:00:00' NOT NULL,
       PRIMARY KEY  (id)
   ) $charset_collate;";

   require_once ABSPATH . 'wp-admin/includes/upgrade.php';
   dbDelta( $sql );

    $sql =  "CREATE TABLE ib_tentee_coupon(
        id int(10) unsigned NOT NULL AUTO_INCREMENT,
        id_service int(10) NOT NULL,
        code varchar(100) DEFAULT '' NOT NULL UNIQUE,
        prix_monaie varchar(100) DEFAULT '' NOT NULL,
        type_coupon varchar(30) NOT NULL,
        limitPersonne bigint(10) NOT NULL,
        maxparPersonne bigint(10) NULL, 
        date_fin date DEFAULT '2022-01-01' NOT NULL, 
        created_on datetime DEFAULT '2022-01-01 00:00:00' NOT NULL,
        modified_on datetime DEFAULT '2022-01-01 00:00:00' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta ($sql);

    $sql2 =  "CREATE TABLE ib_tentee_payement(
        id int(10) unsigned NOT NULL AUTO_INCREMENT,
        id_booking int(10) NOT NULL,
        name_c varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        total_item decimal(10) NOT NULL,
        paid_amount decimal(10) NOT NULL,
        due_amount decimal(10) NOT NULL,
        payment_method varchar(100) NOT NULL,
        Deduction varchar(100) NOT NULL,
        payment_status varchar(100) NOT NULL,
        created_at  datetime NOT NULL ,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta ($sql2);

    $sql =  "CREATE TABLE IB_tentee_week (
        id int(10) unsigned NOT NULL AUTO_INCREMENT,
        nom varchar(100) DEFAULT '' NOT NULL UNIQUE,
        description varchar(100) DEFAULT '' NOT NULL,
        prix varchar(30) NOT NULL,
        Jour text DEFAULT '' NOT NULL, 
        created_on datetime DEFAULT '2022-01-01 00:00:00' NOT NULL,
        modified_on datetime DEFAULT '2022-01-01 00:00:00' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta ($sql);

    $sql =  "CREATE TABLE IB_crenaux_horaire (
        id int(10) unsigned NOT NULL AUTO_INCREMENT,
        id_event int(10) NOT NULL,
        crenaux varchar(300) DEFAULT '' NOT NULL, 
        PRIMARY KEY  (id)
    ) $charset_collate;";
    dbDelta ($sql);

   add_option( 'jal_db_version', $jal_db_version );

   $sql = "CREATE TABLE ib_tentee_historique (
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
    id_employe int(10) NOT NULL,
    id_element int(10) NOT NULL DEFAULT'000',
    actions varchar(300) DEFAULT '' NOT NULL, 
    type_r varchar(100) DEFAULT '' NOT NULL,
    created_on datetime DEFAULT '2022-01-01 00:00:00' NOT NULL,
    PRIMARY KEY  (id)
) $charset_collate;";
dbDelta( $sql );

$sql = "CREATE TABLE ib_tentee_taxe (
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
    nom varchar(100) DEFAULT '' NOT NULL UNIQUE,
    price int(10) NOT NULL,
    PRIMARY KEY  (id)
) $charset_collate;";
dbDelta( $sql );

   add_my_custom_page();
}


