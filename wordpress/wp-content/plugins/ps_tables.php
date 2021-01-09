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
            `id_shop` INT(11) UNSIGNED NOT NULL DEFAULT '1',
            `cif` INT(11) NOT NULL,
            `firstname` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
            `lastname` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
            `email` VARCHAR(128) NOT NULL COLLATE 'utf8_general_ci',
            `date_add` DATETIME NOT NULL,
            `company` VARCHAR(64) NULL COLLATE 'utf8_general_ci',

            PRIMARY KEY (`id_customer`) USING BTREE,
            INDEX `customer_email` (`email`) USING BTREE,
            INDEX `id_shop` (`id_shop`, `date_add`) USING BTREE
            )");

    array_push($queries, "CREATE TABLE IF NOT EXISTS ps_address (
            `id_address` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `id_country` INT(10) UNSIGNED NOT NULL,
            `id_state` INT(10) UNSIGNED NULL,
            `id_customer` INT(10) UNSIGNED NOT NULL DEFAULT '0',
            `company` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
            `lastname` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
            `firstname` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
            `address1` VARCHAR(128) NOT NULL COLLATE 'utf8_general_ci',
            `address2` VARCHAR(128) NULL COLLATE 'utf8_general_ci',
            `postcode` VARCHAR(12) NULL COLLATE 'utf8_general_ci',
            `city` VARCHAR(64) NOT NULL COLLATE 'utf8_general_ci',
            `phone` VARCHAR(32) NULL COLLATE 'utf8_general_ci',
            `phone_mobile` VARCHAR(32) NULL COLLATE 'utf8_general_ci',
            `vat_number` VARCHAR(32) NULL COLLATE 'utf8_general_ci',
            `dni` VARCHAR(16) NULL COLLATE 'utf8_general_ci',
            `date_add` DATETIME NOT NULL,

            PRIMARY KEY (`id_address`) USING BTREE,
            INDEX `address_customer` (`id_customer`) USING BTREE,
            INDEX `id_country` (`id_country`) USING BTREE,
            INDEX `id_state` (`id_state`) USING BTREE
            )");

    array_push($queries, "CREATE TABLE IF NOT EXISTS ps_country (
            `id_country` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `iso_code` VARCHAR(3) NOT NULL COLLATE 'utf8_general_ci',
            `zip_code_format` VARCHAR(12) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',

            PRIMARY KEY (`id_country`) USING BTREE,
            INDEX `country_iso_code` (`iso_code`) USING BTREE
            )");

    array_push($queries, "CREATE TABLE IF NOT EXISTS ps_country_lang (
            `id_country` INT(10) UNSIGNED NOT NULL,
            `id_lang` INT(10) UNSIGNED NOT NULL,
            `name` VARCHAR(64) NOT NULL COLLATE 'utf8_general_ci',

            UNIQUE INDEX `country_lang_index` (`id_country`, `id_lang`) USING BTREE
            )");

    array_push($queries, "CREATE TABLE IF NOT EXISTS ps_state (
            `id_state` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `id_country` INT(11) UNSIGNED NOT NULL,
            `name` VARCHAR(64) NOT NULL COLLATE 'utf8_general_ci',
            `iso_code` VARCHAR(7) NOT NULL COLLATE 'utf8_general_ci',
            
            PRIMARY KEY (`id_state`) USING BTREE,
            INDEX `id_country` (`id_country`) USING BTREE,
            INDEX `statename` (`name`) USING BTREE
            )");

    foreach ($queries as $key => $sql) {
        dbDelta( $sql );
    }
}

function ps_tables_deactivation()
{
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS ps_customer,ps_address,ps_country,ps_state,ps_country_lang";
    $wpdb->get_results($sql);
}

register_activation_hook(__FILE__, 'ps_tables_activation');
register_deactivation_hook(__FILE__, 'ps_tables_deactivation');