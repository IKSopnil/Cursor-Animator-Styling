<?php
/**
 * Plugin Name: Cursor Style & Animation
 * Plugin URI: https://roardev.xyz/cursor-style-animation
 * Description: Transform your website's user experience with beautiful cursor animations and custom cursor styles. Features 4 animation types (trail, particles, ripple, magnetic), 10+ cursor styles, custom cursor images, mobile support, and performance optimizations. Perfect for modern websites looking to enhance interactivity and visual appeal.
 * Version: 1.0.0
 * Author: RoarDev
 * Author URI: https://roardev.xyz
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cursor-style-animation
 * Requires at least: 5.0
 * Tested up to: 6.8
 * Requires PHP: 7.4
 * Tags: cursor, animation, mouse, interactive, effects, custom-cursor, user-experience, visual-effects, website-enhancement, modern-design
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('CURSOR_ANIMATOR_VERSION', '1.0.0');
define('CURSOR_ANIMATOR_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CURSOR_ANIMATOR_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Main plugin class
class CursorAnimator {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'init_settings'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    public function init() {
        load_plugin_textdomain('cursor-style-animation', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
    
    public function enqueue_scripts() {
        // Only load if enabled in settings
        $enabled = get_option('cursor_animator_enabled', '1');
        if ($enabled !== '1') {
            return;
        }
        
        wp_enqueue_script(
            'cursor-animator',
            CURSOR_ANIMATOR_PLUGIN_URL . 'assets/js/cursor-animator.js',
            array(),
            CURSOR_ANIMATOR_VERSION,
            true
        );
        
        wp_enqueue_style(
            'cursor-animator',
            CURSOR_ANIMATOR_PLUGIN_URL . 'assets/css/cursor-animator.css',
            array(),
            CURSOR_ANIMATOR_VERSION
        );
        
        // Pass settings to JavaScript
        wp_localize_script('cursor-animator', 'cursorAnimatorSettings', array(
            'animationType' => get_option('cursor_animator_type', 'trail'),
            'trailLength' => get_option('cursor_animator_trail_length', '20'),
            'trailColor' => get_option('cursor_animator_trail_color', '#ff6b6b'),
            'trailSize' => get_option('cursor_animator_trail_size', '8'),
            'animationSpeed' => get_option('cursor_animator_speed', '0.8'),
            'enableOnMobile' => get_option('cursor_animator_mobile', '0'),
            'cursorStyle' => get_option('cursor_animator_cursor_style', 'default'),
            'customCursorUrl' => get_option('cursor_animator_custom_cursor', ''),
            'cursorSize' => get_option('cursor_animator_cursor_size', '32')
        ));
    }
    
    public function add_admin_menu() {
        add_options_page(
            __('Cursor Style & Animation Settings', 'cursor-style-animation'),
            __('Cursor Style & Animation', 'cursor-style-animation'),
            'manage_options',
            'cursor-animator',
            array($this, 'admin_page')
        );
    }
    
    public function init_settings() {
        register_setting('cursor_animator_options', 'cursor_animator_enabled', array(
            'sanitize_callback' => array($this, 'sanitize_checkbox')
        ));
        register_setting('cursor_animator_options', 'cursor_animator_type', array(
            'sanitize_callback' => array($this, 'sanitize_animation_type')
        ));
        register_setting('cursor_animator_options', 'cursor_animator_trail_length', array(
            'sanitize_callback' => array($this, 'sanitize_trail_length')
        ));
        register_setting('cursor_animator_options', 'cursor_animator_trail_color', array(
            'sanitize_callback' => array($this, 'sanitize_color')
        ));
        register_setting('cursor_animator_options', 'cursor_animator_trail_size', array(
            'sanitize_callback' => array($this, 'sanitize_trail_size')
        ));
        register_setting('cursor_animator_options', 'cursor_animator_speed', array(
            'sanitize_callback' => array($this, 'sanitize_speed')
        ));
        register_setting('cursor_animator_options', 'cursor_animator_mobile', array(
            'sanitize_callback' => array($this, 'sanitize_checkbox')
        ));
        register_setting('cursor_animator_options', 'cursor_animator_cursor_style', array(
            'sanitize_callback' => array($this, 'sanitize_cursor_style')
        ));
        register_setting('cursor_animator_options', 'cursor_animator_custom_cursor', array(
            'sanitize_callback' => array($this, 'sanitize_url')
        ));
        register_setting('cursor_animator_options', 'cursor_animator_cursor_size', array(
            'sanitize_callback' => array($this, 'sanitize_cursor_size')
        ));
    }
    
    // Sanitization callbacks
    public function sanitize_checkbox($value) {
        return $value === '1' ? '1' : '0';
    }
    
    public function sanitize_animation_type($value) {
        $allowed_types = array('trail', 'particles', 'ripple', 'magnetic');
        return in_array($value, $allowed_types) ? $value : 'trail';
    }
    
    public function sanitize_trail_length($value) {
        $value = intval($value);
        return max(5, min(50, $value));
    }
    
    public function sanitize_color($value) {
        return sanitize_hex_color($value) ?: '#ff6b6b';
    }
    
    public function sanitize_trail_size($value) {
        $value = intval($value);
        return max(2, min(20, $value));
    }
    
    public function sanitize_speed($value) {
        $value = floatval($value);
        return max(0.1, min(2.0, $value));
    }
    
    public function sanitize_cursor_style($value) {
        $allowed_styles = array('default', 'pointer', 'crosshair', 'text', 'wait', 'move', 'grab', 'zoom-in', 'zoom-out', 'custom', 'hidden');
        return in_array($value, $allowed_styles) ? $value : 'default';
    }
    
    public function sanitize_url($value) {
        return esc_url_raw($value);
    }
    
    public function sanitize_cursor_size($value) {
        $value = intval($value);
        return max(16, min(64, $value));
    }
    
    public function admin_page() {
        include CURSOR_ANIMATOR_PLUGIN_PATH . 'admin/admin-page.php';
    }
    
    public function activate() {
        // Set default options
        add_option('cursor_animator_enabled', '1');
        add_option('cursor_animator_type', 'trail');
        add_option('cursor_animator_trail_length', '20');
        add_option('cursor_animator_trail_color', '#ff6b6b');
        add_option('cursor_animator_trail_size', '8');
        add_option('cursor_animator_speed', '0.8');
        add_option('cursor_animator_mobile', '0');
        add_option('cursor_animator_cursor_style', 'default');
        add_option('cursor_animator_custom_cursor', '');
        add_option('cursor_animator_cursor_size', '32');
    }
    
    public function deactivate() {
        // Clean up if needed
    }
}

// Initialize the plugin
new CursorAnimator(); 