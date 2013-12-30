<?php
/*
Plugin Name: Power Stats
Plugin URI: http://www.websivu.com/wp-power-stats/
Description: Clean & simple statistics for your wordpress site.
Version: 1.0.3
Author: Igor Buyanov
Text Domain: wp-power-stats
Author URI: http://www.websivu.com
License: A "Slug" license name e.g. GPL2
*/

/*  Copyright 2013  IGOR BUYANOV  (email : info@websivu.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if( get_option('timezone_string') ) {
	date_default_timezone_set( get_option('timezone_string') );
}
	
define('WP_POWER_STATS_VERSION', '1.0.3');
update_option('wp_power_stats_plugin_version', WP_POWER_STATS_VERSION);

if (!defined('WP_POWER_STATS_PLUGIN_DIR')) define('WP_POWER_STATS_PLUGIN_DIR', untrailingslashit(dirname(__FILE__)));

function wp_power_stats_install() {
	global $table_prefix;
	
	if (empty($table_prefix)) $table_prefix = "wp";
	
    $create_browsers = "CREATE TABLE IF NOT EXISTS `{$table_prefix}power_stats_browsers` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `browser` varchar(255) NOT NULL,
      `count` int(11) NOT NULL,
      PRIMARY KEY  (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
    
    $create_os = "CREATE TABLE IF NOT EXISTS `{$table_prefix}power_stats_os` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `os` varchar(255) NOT NULL,
      `count` int(11) NOT NULL,
      PRIMARY KEY  (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
    
    $create_pageviews = "CREATE TABLE IF NOT EXISTS `{$table_prefix}power_stats_pageviews` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `date` date NOT NULL,
      `hits` int(10) unsigned NOT NULL,
      PRIMARY KEY  (`id`),
      UNIQUE KEY `post_id` (`date`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
    
    $create_posts = "CREATE TABLE IF NOT EXISTS `{$table_prefix}power_stats_posts` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `post_id` int(16) NOT NULL,
      `date` date NOT NULL,
      `hits` int(10) unsigned NOT NULL,
      PRIMARY KEY  (`id`),
      UNIQUE KEY `post_id` (`post_id`,`date`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=1;";
    
    $create_searches = "CREATE TABLE IF NOT EXISTS `{$table_prefix}power_stats_searches` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `terms` varchar(255) DEFAULT NULL,
      `count` int(11) NOT NULL,
      PRIMARY KEY  (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
    
    $create_visits = "CREATE TABLE IF NOT EXISTS `{$table_prefix}power_stats_visits` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `date` date NOT NULL,
      `ip` varchar(20) NOT NULL,
      `time` time NOT NULL,
      `country` varchar(4) NOT NULL,
      `device` varchar(16) NOT NULL,
      `referer` text NOT NULL,
      `browser` varchar(255) NOT NULL,
      `browser_version` varchar(16) NOT NULL,
      `os` varchar(255) NOT NULL,
      `is_search_engine` tinyint(4) NOT NULL,
      `is_bot` tinyint(4) NOT NULL,
      `user_agent` text NOT NULL,
      PRIMARY KEY  (`id`),
      UNIQUE KEY `date` (`date`,`ip`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
    
    $create_referers = "CREATE TABLE IF NOT EXISTS `{$table_prefix}power_stats_referers` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `referer` text NOT NULL,
      `count` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			
	dbDelta($create_browsers);
	dbDelta($create_os);
	dbDelta($create_pageviews);
	dbDelta($create_posts);
	dbDelta($create_searches);
	dbDelta($create_visits);
	dbDelta($create_referers);
}


function wp_power_stats_activate() {

	if (is_admin()) {

    global $wpdb;

		// check if it is a network activation - if so, run the activation function for each blog id
		if (function_exists('is_multisite') && is_multisite()) {
       
	        if ($networkwide) {

              $old_blog = $wpdb->blogid;

	            // Get all blog ids
	            $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

	            foreach ($blogids as $blog_id) {
	                switch_to_blog($blog_id);
	                wp_power_stats_install();
	            }

	            switch_to_blog($old_blog);
	            return;
	        }
	        
		} else {
			
			wp_power_stats_install();
			
		}

	
	}
	
}	
register_activation_hook(__FILE__, 'wp_power_stats_activate');


function set_tracking_cookie() {
	if(!session_id()) session_start();
}
add_action('init', 'set_tracking_cookie');


function intern() {
    		
	// Internationalization
	load_plugin_textdomain('wp-power-stats', false, basename(dirname(__FILE__)) . '/languages');
	
}
add_action('plugins_loaded', 'intern');

function power_stats_init() {
	
	global $wpdb, $table_prefix, $post;
	
	// Do not track administration backend hits
	if( !is_admin() ) {
		require_once WP_POWER_STATS_PLUGIN_DIR . '/powerStats.class.php';
		require_once WP_POWER_STATS_PLUGIN_DIR . '/vendor/mobile-detect/Mobile_Detect.php';
		require_once WP_POWER_STATS_PLUGIN_DIR . '/vendor/search-terms/SearchEngines.php';
		require_once WP_POWER_STATS_PLUGIN_DIR . '/vendor/browser-os/Browser.php';
		$power_stats = new PowerStats($wpdb, $table_prefix, $post);
	}

}
add_action('shutdown', 'power_stats_init');


function power_stats_statistics_help() {

    $screen = get_current_screen();

    if ($screen->id != 'toplevel_page_wp-power-stats')
        return;

    $screen->add_help_tab(array(
        'id'	=> 'my_help_tab',
        'title'	=> __('Overview'),
        'content'	=> '<p>'.__('The regions on your Statistics screen are:','wp-power-stats').'</p>
<p><strong>'.__('Summary','wp-power-stats').'</strong> - '.__('Shows the number of visitors and page views during different time periods: today, this week, this month.','wp-power-stats').'</p>
<p><strong>'.__('Devices','wp-power-stats').'</strong> - '.__('Shows the top 3 devices your visitors are using.','wp-power-stats').'</p>
<p><strong>'.__('Visitors & Page Views','wp-power-stats').'</strong> - '.__('Shows a graph of visitors and page views during the last 11 days. You can view the precise numbers when you hover the graph with your mouse.','wp-power-stats').'</p>
<p><strong>'.__('Traffic Source','wp-power-stats').'</strong> - '.__('Displays the traffic source to your web site.','wp-power-stats').'</p>
<p><strong>'.__('Browsers','wp-power-stats').'</strong> - '.__('Displays the top 3 most used web browser of your visitors.','wp-power-stats').'</p>
<p><strong>'.__('Operating Systems','wp-power-stats').'</strong> - '.__('Displays the top 3 most used operating system of your visitors.','wp-power-stats').'</p>
<p><strong>'.__('Visitor Map','wp-power-stats').'</strong> - '.__('Shows the geoprahical map of your visitors. Hover over a country, to see the exact visitor number to your site from that country.','wp-power-stats').'</p>
<p><strong>'.__('Top Posts','wp-power-stats').'</strong> - '.__('Shows the most viewed posts of your wordpress site.','wp-power-stats').'</p>
<p><strong>'.__('Top Links','wp-power-stats').'</strong> - '.__('Shows the most common referer to your site.','wp-power-stats').'</p>
<p><strong>'.__('Top Search Terms','wp-power-stats').'</strong> - '.__('Shows the most used keywords used to find your website.','wp-power-stats').'</p>'
    ));
}


function wp_power_stats_menu() {
 
    wp_enqueue_style('skeleton', plugin_dir_url(__FILE__) . '/styles/grid.css', true, '1.0');
    wp_enqueue_style('layout', plugin_dir_url(__FILE__) . '/styles/styles.css', true, '1.0');
	
	wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
	wp_enqueue_script('google-charts', 'https://www.google.com/jsapi');
 
	$statistics_menu = add_menu_page(__('Statistics','wp-power-stats'), __('Statistics','wp-power-stats'), 'manage_options', 'wp-power-stats', 'wp_power_stats', 'dashicons-chart-pie', 3.119);
 
	add_action('load-'.$statistics_menu, 'power_stats_statistics_help');
	
}
add_action('admin_menu', 'wp_power_stats_menu');


function wp_power_stats() {

	global $wpdb;

	require_once WP_POWER_STATS_PLUGIN_DIR . '/admin.php';
	require_once WP_POWER_STATS_PLUGIN_DIR . '/views/dashboard.php';

}