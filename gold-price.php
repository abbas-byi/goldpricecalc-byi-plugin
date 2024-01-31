<?php

/**
* Plugin Name: Gold Price Based on Weight

* Description:       Add a global price per 1 gram of Gold 18K, Gold 22K, Gold 24K, Silver, and Platinum and then use the weight of each product to automatically calculate its price based on this rate.
* Version:           2.0
* Author:            Build Your Innovation
* Author URI:        https://www.buildyourinnovation.com/
* License:           GPL-2.0+
* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
* Text Domain:       my-textdomain
* Domain Path:       /languages
*/


define( 'PTGold__FILE__', __FILE__ );
define( 'PTGold_PATH', plugin_dir_path( PTGold__FILE__ ) );
define( 'PTGold_URL', plugins_url( '/', PTGold__FILE__ ) );

define( 'PTGold_ASSETS_PATH', PTGold_PATH . 'assets/' );
define( 'PTGold_ASSETS_URL', PTGold_URL . 'assets/' );

require PTGold_PATH . 'includes/plugin.php';

