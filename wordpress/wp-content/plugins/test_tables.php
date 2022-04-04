<?php
/**
 * Plugin Name: Test table
 * Plugin URI: https://jjmontalban.github.io/
 * Description: Create some tables to import data. CAUTION: deactivate plugin will drop tables!
 * Version: 1.0
 * Author: JJMontalban
 * Author URI: https://jjmontalban.github.io/
 */
defined('ABSPATH') or die('No no no');

function test_table_activation()
{
    global $wpdb;
    $wpdb->hide_errors();

    $collate = '';
    if ( $wpdb->has_cap( 'collation' ) ) { $collate = $wpdb->get_charset_collate(); }
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $queries = array();

    array_push($queries, "CREATE TABLE IF NOT EXISTS test_table (
            `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `firstname` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
            `email` VARCHAR(128) NOT NULL COLLATE 'utf8_general_ci',
            `date_add` DATETIME NOT NULL,

            PRIMARY KEY (`id`) USING BTREE
            )");


    foreach ($queries as $key => $sql) {
        dbDelta( $sql );
    }
}

function test_table_deactivation()
{
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS test_table";
    $wpdb->get_results($sql);
}

register_activation_hook(__FILE__, 'test_table_activation');
register_deactivation_hook(__FILE__, 'test_table_deactivation');