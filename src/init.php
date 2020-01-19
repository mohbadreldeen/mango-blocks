<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;

}
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package Mango-Blocks
 */

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function mango_blocks_assets()
{ // phpcs:ignore
    // Register block styles for both frontend + backend.
    wp_register_style(
        'mango_blocks-style-css', // Handle.
        plugins_url('dist/blocks.style.build.css', dirname(__FILE__)), // Block style CSS.
        array('wp-editor'), // Dependency to include the CSS after it.
        null// filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
    );

    // Register block editor script for backend.
    wp_register_script(
        'mango_blocks-block-js', // Handle.
        plugins_url('/dist/blocks.build.js', dirname(__FILE__)), // Block.build.js: We register the block here. Built with Webpack.
        array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), // Dependencies, defined above.
        null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
        true// Enqueue the script in the footer.
    );

    // Register block editor styles for backend.
    wp_register_style(
        'mango_blocks-editor-css', // Handle.
        plugins_url('dist/blocks.editor.build.css', dirname(__FILE__)), // Block editor CSS.
        array('wp-edit-blocks'), // Dependency to include the CSS after it.
        null// filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
    );

    // WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
    wp_localize_script(
        'mango_blocks-js',
        'mangoGlobal', // Array containing dynamic data for a JS Global.
        [
            'pluginDirPath' => plugin_dir_path(__DIR__),
            'pluginDirUrl' => plugin_dir_url(__DIR__),
            // Add more data here that you want to access from `cgbGlobal` object.
        ]
    );

    /**
     * Register Gutenberg block on server-side.
     *
     */
    register_block_type(
        'mb/block-mango-blocks', array(
            // Enqueue blocks.style.build.css on both frontend & backend.
            'style' => 'mango_blocks-style-css',
            // Enqueue blocks.build.js in the editor only.
            'editor_script' => 'mango_blocks-js',
            // Enqueue blocks.editor.build.css in the editor only.
            'editor_style' => 'mango_blocks-editor-css',
        )
    );
}
add_action('init', 'mango_blocks_assets');

function mango_blocks_image_filter($block_content, $block)
{

    if ("core/image" !== $block['blockName']) {
        return $block_content;
    }
    $output = sprintf('<div class="%s">', $block['attrs']['filter']);
    $output .= $block_content;
    $output .= '</div>';

    return $output;
}
add_filter('render_block', 'mango_blocks_image_filter', 10, 3);
