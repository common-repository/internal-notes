<?php
/**
 * Plugin Name.
 *
 * @package   Exxica
 * @author    Gaute Rønningen <gaute@exxica.com>
 * @link      http://exxica.com
 * @copyright 2014 Exxica AS
 */

/**
 * Plugin class.
 *
 * @package Exxica_TodoList_Admin
 * @author  Gaute Rønningen <gaute@exxica.com>
 */
class Exxica_TodoList_Admin {

    protected static $instance = null;
    protected $plugin_screen_hook_suffix = null;

    /**
     * Initialize the plugin.
     *
     * @since     1.0.1
     */
    private function __construct() {
        $plugin = Exxica_Todo::get_instance();
        $this->plugin_slug = $plugin->get_plugin_slug();

        add_action( 'add_meta_boxes', array( $this, 'todo_content_box' ) );

        add_action( 'save_post', array( $this, 'todo_save_postdata' ), 9999 );
    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.1
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Adds metabox to certain posts.
     *
     * @since     1.0.1
     */
	public function todo_content_box() {
		$screens = array( 'page', 'post', 'landing', 'question', 'download', 'attachment' );

		foreach ( $screens as $screen ) {

	        add_meta_box(
	            'todolist',
	            __( 'What remains to do:', $this->plugin_slug ),
	            function( $post ) {
                    $plugin = Exxica_Todo::get_instance();
                    $slug = $plugin->get_plugin_slug();
					$lib = Exxica_TodoLibrary_Admin::get_instance();

                    wp_nonce_field( 'todo_inner_content_box', 'todo_inner_content_box_nonce' );
					echo $lib->addHTML_textarea( array(
						'id' => 'todolist_textarea',
						'value' => get_post_meta( $post->ID, 'todolist', true ),
						'extra_text' => __('This field is for personal notes only and will never be shown to the public.', $slug )
					) );
				},
	            $screen
	        );
	    }
	}

    /**
     * Saves metadata to database.
     *
     * @since     1.0.1
     *
     * @param  	  $post_id 	The post->ID of this post.
     */
	public function todo_save_postdata( $post_id ) {
		$lib = Exxica_TodoLibrary_Admin::get_instance();

		if(isset($_POST['todo_inner_content_box_nonce'])) {
            if(!$lib->validateInput( $post_id, array( 'compareKey' => 'todo_inner_content_box', 'compareValue' => $_POST['todo_inner_content_box_nonce'] ) ) ) 
                return $post_id;

    		update_post_meta( $post_id, 'todolist', $_POST['todolist_textarea'] );
        } else {
            return $post_id;
        }
	}
}