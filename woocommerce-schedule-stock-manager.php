<?php


/**
 * Plugin Name: WooCommerce Schedule Stock Manager by Great Website Studio
 * Description: Help you manage the stock quantity for each products.
 * Version: 0.2
 * Author: Great Website Studio
 * Author URI: https://great.web.id
 * Requires PHP: 8.0
 * WC tested up to: 7.2.2
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: woocommerce-schedule-stock-manager-by-great-website-studio
 * 
 * Copyright (c) 2022 Great Website Studio. All rights reserved.
 * 
 * @package WooCommerce Schedule Stock Manager by Great Website Studio
 */


/**
 * Global Constants
 *  
 */

defined('ABSPATH') or die('Hey, you can\t access this file, you silly human !');

if (!defined('WSSMGWS_FILE')) {

    define('WSSMGWS_FILE', __FILE__);
}

if (!defined('WSSMGWS_PATH')) {

    define('WSSMGWS_PATH', plugin_dir_path(__FILE__));
}


/**
 * Load src folder
 *  
 */

require_once WSSMGWS_PATH . 'src/WooCommerceScheduleStockManager.php';
require_once WSSMGWS_PATH . 'src/WooCommerceAdmin.php';


/**
 * Register Activation and Deactivation Hook
 *  
 */

register_activation_hook(
    __FILE__,
    array(
        GreatWebsiteStudio\WooCommerceScheduleStockManager::class,
        'activate'
    )
);

register_deactivation_hook(
    __FILE__,
    array(
        GreatWebsiteStudio\WooCommerceScheduleStockManager::class,
        'deactivate'
    )
);


GreatWebsiteStudio\WooCommerceScheduleStockManager::setup();
GreatWebsiteStudio\WooCommerceAdmin::setup();
