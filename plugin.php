<?php
/**
 * Plugin Name: Mango Blockks
 * Plugin URI: http://www.truesightlabs.com/
 * Description: Mango Blocks — Is a coolection Gutenberg Blocks and filters.
 * Author: mobadreldeen
 * Author URI: http://www.truesightlabs.com/
 * Version: 1.0.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Mango-Blocks
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';
