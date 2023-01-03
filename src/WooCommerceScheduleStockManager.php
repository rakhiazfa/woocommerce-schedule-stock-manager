<?php

namespace GreatWebsiteStudio;

require_once WSSMGWS_PATH . 'src/Schedule.php';

/**
 * Class WooCommerceScheduleStockManager
 * 
 * @author Great Website Studio
 */
class WooCommerceScheduleStockManager
{

    /**
     * Setup the plugin.
     * 
     * @return void
     */
    public static function setup()
    {

        Schedule::setup();
    }

    /**
     * WooCommerce Schedule Stock Manager Activation Script
     * 
     * @return void
     */
    private static function script_activation()
    {

        $error = 'Required <b>WooCommerce</b> plugin activate.';

        if (!class_exists('WooCommerce')) {

            die($error);
        }
    }

    /**
     * Activate the plugin.
     * 
     * @return void
     */
    public static function activate()
    {

        self::script_activation();
    }

    /**
     * Deactivate the plugin.
     * 
     * @return void
     */
    public static function deactivate()
    {

        //  
    }
}
