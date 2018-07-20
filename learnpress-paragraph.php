<?php
/*
Plugin Name: LearnPress - Paragraph Question
Plugin URI: http://thimpress.com/learnpress
Description: Supports type of question Paragraph lets user fill out the text into one ( or more than one ) space.
Author: ThimPress
Version: 3.0.3
Author URI: http://thimpress.com
Tags: learnpress, lms, add-on, paragraph
Text Domain: learnpress-paragraph
Domain Path: /languages/
*/

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

define( 'LP_ADDON_PARAGRAPH_FILE', __FILE__ );
define( 'LP_ADDON_PARAGRAPH_VER', '3.0.3' );
define( 'LP_ADDON_PARAGRAPH_REQUIRE_VER', '3.0.0' );
define( 'LP_QUESTION_PARAGRAPH_VER', '3.0.3' );

/**
 * Class LP_Addon_Paragraph_Preload
 */
class LP_Addon_Paragraph_Preload {

	/**
	 * LP_Addon_Paragraph_Preload constructor.
	 */
	public function __construct() {
		add_action( 'learn-press/ready', array( $this, 'load' ) );
	}

	/**
	 * Load addon
	 */
	public function load() {
		LP_Addon::load( 'LP_Addon_Paragraph', 'inc/load.php', __FILE__ );
	}

}

new LP_Addon_Paragraph_Preload();