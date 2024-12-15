<?php
/**
 * Plugin Name: Honda Services Widget
 * Description: Custom Elementor widget for Honda services grid and social media
 * Version: 1.0
 * Author: Jesus Jimenez
 */

if (!defined('ABSPATH')) exit;

final class Honda_Services_Widget_Plugin {
    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
    const MINIMUM_PHP_VERSION = '7.0';

    private static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init() {
        // Check for required Elementor version
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_elementor']);
            return;
        }

        // Add Plugin actions
        add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
    }

    public function init_widgets() {
        require_once(__DIR__ . '/widgets/honda-services-grid.php');
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Honda_Services_Grid());
    }

    public function add_elementor_widget_categories($elements_manager) {
        $elements_manager->add_category(
            'honda-widgets',
            [
                'title' => __('Honda Widgets', 'honda-services'),
                'icon' => 'fa fa-car',
            ]
        );
    }
}

Honda_Services_Widget_Plugin::instance();