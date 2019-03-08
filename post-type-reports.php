<?php

/*
Plugin Name: Post Type Reports
Description: Geração de Relatórios
Version: 1.0
Author: Amanda Louise Acosta
 */

/*
 * Plugin constants
 */
if (!defined('ABSPATH')) {
    die;
}

/**
 * Class Reports
 *
 * This class creates the option page and add the web app script
 */
class Reports
{

    public $plugin;
    /**
     * IdentificacaoCidade constructor.
     *
     * The main plugin actions registered for WordPress
     */
    public function __construct()
    {
        $this->plugin = plugin_basename(__FILE__);

    }

    public function enqueue()
    {
        wp_enqueue_style('styles', plugins_url('/css/style.css', __FILE__));
        wp_enqueue_style('chosen-css', plugins_url('/css/chosen.css', __FILE__));
        wp_enqueue_script('script', plugins_url('/js/scripts.js', __FILE__));
        wp_enqueue_script('user-script', plugins_url('/js/user-scripts.js', __FILE__));
        wp_enqueue_script('chosen', plugins_url('/js/chosen.jquery.min.js', __FILE__));
        wp_enqueue_script('general-script', plugins_url('/js/general-scripts.js', __FILE__));
    }

    public function register()
    {
        add_action('admin_menu', array($this, 'addAdminMenu'));
        add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }

    public function settings_link($links)
    {
        $settings_link = '<a href="admin.php?page=post-type-reports">Settings</a>';
        array_push($links, $settings_link);
        return $links;
    }

    public function addAdminMenu()
    {
        add_menu_page('Custom Reports', 'Custom Reports', 'manage_options', 'post-type-reports', array($this, 'admin_index'), '', 110);
    }

    public function admin_index()
    {
        require_once plugin_dir_path(__FILE__) . 'templates/admin.php';
    }
}

require_once 'functions/actions.php';

/*
 * Starts our plugin class, easy!
 */
if (class_exists('Reports')) {
    $reports = new Reports();
    $reports->register();
}