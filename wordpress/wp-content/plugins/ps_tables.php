<?php
/**
 * Plugin Name: Ps tables
 * Plugin URI: https://jjmontalban.github.io/
 * Description: Create some tables to import data from Prestashop. CAUTION: deactivate plugin will drop tables!
 * Version: 1.0
 * Author: JJMontalban
 * Author URI: https://jjmontalban.github.io/
 */
defined('ABSPATH') or die('No no no');

function ps_tables_activation()
{
    global $wpdb;
    $wpdb->hide_errors();

    $collate = '';
    if ( $wpdb->has_cap( 'collation' ) ) { $collate = $wpdb->get_charset_collate(); }
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $queries = array();

    array_push($queries, "CREATE TABLE IF NOT EXISTS ps_customer (
            `id_customer` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `firstname` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
            `lastname` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
            `company` VARCHAR(64) NULL COLLATE 'utf8_general_ci',
            `email` VARCHAR(128) NOT NULL COLLATE 'utf8_general_ci',
            `phone_1` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
            `phone_2` VARCHAR(32) NULL COLLATE 'utf8_general_ci',
            `address_1` VARCHAR(128) NOT NULL COLLATE 'utf8_general_ci',
            `address_2` VARCHAR(128) NULL COLLATE 'utf8_general_ci',
            `postcode` VARCHAR(12) NOT NULL COLLATE 'utf8_general_ci',
            `city` VARCHAR(64) NOT NULL COLLATE 'utf8_general_ci',
            `state` VARCHAR(64) NOT NULL COLLATE 'utf8_general_ci',
            `country` VARCHAR(64) NOT NULL COLLATE 'utf8_general_ci',
            `shop` VARCHAR(64) NOT NULL COLLATE 'utf8_general_ci',
            `cif` VARCHAR(64) NOT NULL COLLATE 'utf8_general_ci',
            `vat_number` VARCHAR(32) NULL COLLATE 'utf8_general_ci',
            `date_add` DATETIME NOT NULL,

            PRIMARY KEY (`id_customer`) USING BTREE
            )");


    foreach ($queries as $key => $sql) {
        dbDelta( $sql );
    }
}

function ps_tables_deactivation()
{
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS ps_customer";
    $wpdb->get_results($sql);
}

register_activation_hook(__FILE__, 'ps_tables_activation');
register_deactivation_hook(__FILE__, 'ps_tables_deactivation');