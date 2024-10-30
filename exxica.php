<?php
/**
 * @package   Exxica
 * @author    Gaute Rønningen <gaute@exxica.com>
 * @link      http://exxica.com
 * @copyright 2014 Exxica AS
 *
 * @wordpress-plugin
 * Plugin Name:       Internal notes
 * Plugin URI:        http://exxica.com
 * Description:       Adds a simple textarea to posting and page editing, for internal notes.
 * Version:           1.0.2
 * Author:            Gaute Rønningen
 * Author URI:        http://exxica.com
 * Text Domain:       exxica-todo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-exxica-todo.php' );

register_activation_hook( __FILE__, array( 'Exxica_Todo', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Exxica_Todo', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'Exxica_Todo', 'get_instance' ) );



/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-exxica-todo-admin.php' );
	add_action( 'plugins_loaded', array( 'Exxica_Todo_Admin', 'get_instance' ) );

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-todo-library-admin.php' );
	add_action( 'plugins_loaded', array( 'Exxica_TodoLibrary_Admin', 'get_instance' ) );

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-todolist-admin.php' );
	add_action( 'plugins_loaded', array( 'Exxica_TodoList_Admin', 'get_instance' ) );
}