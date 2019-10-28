<?php
/**
 * Halo16
 *
 * Plugin to show a page preview
 *
 * @package   halo16
 * @author    Retorica Comunicazione
 * @license   GPL-3.0
 * @link      retorica.net
 * @copyright 2016 Retorica Comunicazione
 *
 * @wordpress-plugin
 * Plugin Name: Halo16
 * Plugin URI:  retorica.net
 * Description: Plugin to display a page preview
 * Version:     1.0.0
 * Author:      Retorica Comunicazione
 * Author URI:  retorica.net
 * Text Domain: Halo16
 * License:     GPL-3.0
 * Domain Path: /lang
 */

namespace halo16;

if ( ! defined( 'WPINC' ) ) {
    die;
}

$args = array(
  'controllers_path' => plugin_dir_path(__FILE__).'controllers/',
  'views_path' => plugin_dir_path(__FILE__).'views/',
  'models_path' => plugin_dir_path(__FILE__).'models/',
  'languages_path' => plugin_dir_path(__FILE__).'lang/',
  'plugin_url' =>  plugins_url().'/halo16/'
);

require_once(plugin_dir_path(__FILE__) . "includes/factory/interface-factory.php");
require_once(plugin_dir_path(__FILE__) . "includes/factory/factory.php");
require_once(plugin_dir_path(__FILE__) . "includes/utilities.php");

$factory = Factory::getInstance($args);

$factory->createController('plugin', 'plugin');
