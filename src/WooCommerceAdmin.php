<?php

namespace GreatWebsiteStudio;

/**
 * Class WooCommerceAdmin
 * 
 * @author Great Website Studio
 */
class WooCommerceAdmin
{

    /**
     * Setup Admin
     * 
     * @return void
     */
    public static function setup()
    {

        self::register_admin_scripts();
    }

    /**
     * Register Admin Scripts
     * 
     * @return void
     */
    private static function register_admin_scripts()
    {

        add_action(
            'admin_enqueue_scripts',
            array(self::class, 'admin_enqueue')
        );

        add_action(
            'woocommerce_product_options_stock_status',
            array(self::class, 'product_options')
        );

        add_action(
            'woocommerce_process_product_meta',
            array(self::class, 'save_product_options')
        );

        add_action(
            'woocommerce_product_after_variable_attributes',
            array(self::class, 'variation_product_options'),
            10,
            3
        );

        add_action(
            'woocommerce_save_product_variation',
            array(self::class, 'save_variation_product_options'),
            10,
            3
        );
    }

    /**
     * Admin Enqueue
     * 
     * @return void
     */
    public static function admin_enqueue()
    {

        wp_enqueue_style(
            'wssmgws_admin_style',
            plugins_url('/assets/css/wssmgws-admin-app.css', WSSMGWS_FILE),
        );

        wp_enqueue_script(
            'wssmgws_admin_script',
            plugins_url('/assets/js/wssmgws-admin-app.js', WSSMGWS_FILE),
        );
    }

    /**
     * Product Options
     * 
     * @return void
     */
    public static function product_options()
    {
        $manage_stock = get_post_meta(get_the_ID(), '_manage_stock', true);
        $schedule_mode = get_post_meta(get_the_ID(), 'wssmgws_schedule_mode', true);

        $manage_stock_display = "style='display: none'";
        $display = "style='display: none'";

        if ($schedule_mode == 'yes') {

            $display = "style='display:block'";
        }

        if ($manage_stock == 'yes') {

            $manage_stock_display = "style='display:block'";
        }

        echo "<div class='wssmgws_enable_manage_stock' $manage_stock_display>";

        woocommerce_wp_checkbox(array(
            'id'      => 'wssmgws_schedule_mode',
            'value'   => get_post_meta(get_the_ID(), 'wssmgws_schedule_mode', true),
            'label'   => 'Schedule Stock Manage',
            'description' => 'Enable to auto update stock quantity per Daily.',
        ));

        echo "<div class='wssmgws_additional_options' $display>";

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_daily_at',
            'value'   => get_post_meta(get_the_ID(), 'wssmgws_daily_at', true),
            'label'   => 'Daily At?',
            'type'    => 'time',
            'class'   => 'wssmgws_time_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_monday_stock_quantity',
            'value'   => get_post_meta(get_the_ID(), 'wssmgws_monday_stock_quantity', true),
            'label'   => 'Monday',
            'type'    => 'number',
            'class'   => 'wssmgws_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_tuesday_stock_quantity',
            'value'   => get_post_meta(get_the_ID(), 'wssmgws_tuesday_stock_quantity', true),
            'label'   => 'Tuesday',
            'type'    => 'number',
            'class'   => 'wssmgws_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_wednesday_stock_quantity',
            'value'   => get_post_meta(get_the_ID(), 'wssmgws_wednesday_stock_quantity', true),
            'label'   => 'Wednesday',
            'type'    => 'number',
            'class'   => 'wssmgws_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_thursday_stock_quantity',
            'value'   => get_post_meta(get_the_ID(), 'wssmgws_thursday_stock_quantity', true),
            'label'   => 'Thursday',
            'type'    => 'number',
            'class'   => 'wssmgws_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_friday_stock_quantity',
            'value'   => get_post_meta(get_the_ID(), 'wssmgws_friday_stock_quantity', true),
            'label'   => 'Friday',
            'type'    => 'number',
            'class'   => 'wssmgws_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_saturday_stock_quantity',
            'value'   => get_post_meta(get_the_ID(), 'wssmgws_saturday_stock_quantity', true),
            'label'   => 'Saturday',
            'type'    => 'number',
            'class'   => 'wssmgws_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_sunday_stock_quantity',
            'value'   => get_post_meta(get_the_ID(), 'wssmgws_sunday_stock_quantity', true),
            'label'   => 'Sunday',
            'type'    => 'number',
            'class'   => 'wssmgws_number_field',
        ));

        echo "</div>";

        echo "</div>";
    }

    /**
     * Save Product Options
     * 
     * @param mixed $post_id
     * 
     * @return void
     */
    public static function save_product_options($post_id)
    {
        $schedule_mode = 'no';

        $monday_stock_quantity = 0;
        $tuesday_stock_quantity = 0;
        $wednesday_stock_quantity = 0;
        $thursday_stock_quantity = 0;
        $friday_stock_quantity = 0;
        $saturday_stock_quantity = 0;
        $sunday_stock_quantity = 0;

        if (isset($_POST['wssmgws_schedule_mode'])) {

            $enable_manage_stock = sanitize_text_field($_POST['_manage_stock'] ?? 'no');
            $schedule_mode = sanitize_text_field($_POST['wssmgws_schedule_mode']);
            $daily_at = sanitize_text_field($_POST['wssmgws_daily_at']);

            if ($enable_manage_stock == 'no') {

                $schedule_mode = 'no';
            }

            $monday_stock_quantity = (int) sanitize_text_field($_POST['wssmgws_monday_stock_quantity']);
            $tuesday_stock_quantity = (int) sanitize_text_field($_POST['wssmgws_tuesday_stock_quantity']);
            $wednesday_stock_quantity = (int) sanitize_text_field($_POST['wssmgws_wednesday_stock_quantity']);
            $thursday_stock_quantity = (int) sanitize_text_field($_POST['wssmgws_thursday_stock_quantity']);
            $friday_stock_quantity = (int) sanitize_text_field($_POST['wssmgws_friday_stock_quantity']);
            $saturday_stock_quantity = (int) sanitize_text_field($_POST['wssmgws_saturday_stock_quantity']);
            $sunday_stock_quantity = (int) sanitize_text_field($_POST['wssmgws_sunday_stock_quantity']);
        }

        update_post_meta($post_id, 'wssmgws_schedule_mode', $schedule_mode);
        update_post_meta($post_id, 'wssmgws_daily_at', date("H:i", strtotime($daily_at)));

        update_post_meta($post_id, 'wssmgws_monday_stock_quantity', $monday_stock_quantity);
        update_post_meta($post_id, 'wssmgws_tuesday_stock_quantity', $tuesday_stock_quantity);
        update_post_meta($post_id, 'wssmgws_wednesday_stock_quantity', $wednesday_stock_quantity);
        update_post_meta($post_id, 'wssmgws_thursday_stock_quantity', $thursday_stock_quantity);
        update_post_meta($post_id, 'wssmgws_friday_stock_quantity', $friday_stock_quantity);
        update_post_meta($post_id, 'wssmgws_saturday_stock_quantity', $saturday_stock_quantity);
        update_post_meta($post_id, 'wssmgws_sunday_stock_quantity', $sunday_stock_quantity);

        if ($schedule_mode == 'yes') {

            wp_clear_scheduled_hook('wssmgws_do_it_every_minute', array('post_id' => $post_id));

            wp_schedule_event(
                time(),
                'wssmgws_every_minute',
                'wssmgws_do_it_every_minute',
                array('post_id' => $post_id)
            );
        }
    }

    /**
     * Variation Product Options
     * 
     * @param mixed $loop
     * @param mixed $variation_data
     * @param mixed $variation
     * 
     * @return void
     */
    public static function variation_product_options($loop, $variation_data, $variation)
    {
        $manage_stock = get_post_meta($variation->ID, '_manage_stock', true);
        $schedule_mode = get_post_meta($variation->ID, 'wssmgws_schedule_mode', true);

        $manage_stock_display = "style='display: none'";
        $display = "style='display: none'";

        if ($schedule_mode == 'yes') {

            $display = "style='display:block'";
        }

        if ($manage_stock == 'yes') {

            $manage_stock_display = "style='display:block'";
        }

        echo "<div class='wssmgws_enable_variation_manage_stock' $manage_stock_display>";

        woocommerce_wp_checkbox(array(
            'id'      => 'wssmgws_schedule_mode[' . $variation->ID . ']',
            'class'      => 'wssmgws_schedule_mode checkbox',
            'value'   => get_post_meta($variation->ID, 'wssmgws_schedule_mode', true),
            'label'   => '&nbsp;&nbsp;Schedule Stock Manage',
        ));

        echo "<div class='wssmgws_additional_variation_options' $display>";

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_daily_at[' . $variation->ID . ']',
            'value'   => get_post_meta($variation->ID, 'wssmgws_daily_at', true),
            'label'   => 'Daily At?&nbsp;&nbsp;&nbsp;&nbsp;',
            'type'    => 'time',
            'class'   => 'wssmgws_time_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_monday_stock_quantity[' . $variation->ID . ']',
            'value'   => get_post_meta($variation->ID, 'wssmgws_monday_stock_quantity', true),
            'label'   => 'Monday',
            'type'    => 'number',
            'class'   => 'wssmgws_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_tuesday_stock_quantity[' . $variation->ID . ']',
            'value'   => get_post_meta($variation->ID, 'wssmgws_tuesday_stock_quantity', true),
            'label'   => 'Tuesday',
            'type'    => 'number',
            'class'   => 'wssmgws_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_wednesday_stock_quantity[' . $variation->ID . ']',
            'value'   => get_post_meta($variation->ID, 'wssmgws_wednesday_stock_quantity', true),
            'label'   => 'Wednesday',
            'type'    => 'number',
            'class'   => 'wssmgws_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_thursday_stock_quantity[' . $variation->ID . ']',
            'value'   => get_post_meta($variation->ID, 'wssmgws_thursday_stock_quantity', true),
            'label'   => 'Thursday',
            'type'    => 'number',
            'class'   => 'wssmgws_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_friday_stock_quantity[' . $variation->ID . ']',
            'value'   => get_post_meta($variation->ID, 'wssmgws_friday_stock_quantity', true),
            'label'   => 'Friday',
            'type'    => 'number',
            'class'   => 'wssmgws_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_saturday_stock_quantity[' . $variation->ID . ']',
            'value'   => get_post_meta($variation->ID, 'wssmgws_saturday_stock_quantity', true),
            'label'   => 'Saturday',
            'type'    => 'number',
            'class'   => 'wssmgws_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'wssmgws_sunday_stock_quantity[' . $variation->ID . ']',
            'value'   => get_post_meta($variation->ID, 'wssmgws_sunday_stock_quantity', true),
            'label'   => 'Sunday',
            'type'    => 'number',
            'class'   => 'wssmgws_number_field',
        ));

        echo "</div>";

        echo "</div>";
    }

    /**
     * Save Variation Product Options
     * 
     * @param mixed $post_id
     * 
     * @return void
     */
    public static function save_variation_product_options($post_id, $loop)
    {
        $schedule_mode = 'no';

        $monday_stock_quantity = 0;
        $tuesday_stock_quantity = 0;
        $wednesday_stock_quantity = 0;
        $thursday_stock_quantity = 0;
        $friday_stock_quantity = 0;
        $saturday_stock_quantity = 0;
        $sunday_stock_quantity = 0;

        if (isset($_POST['wssmgws_schedule_mode'])) {

            $enable_manage_stock = sanitize_text_field($_POST['variable_manage_stock'][$loop] ?? 'no');
            $schedule_mode = sanitize_text_field($_POST['wssmgws_schedule_mode'][$post_id]);
            $daily_at = sanitize_text_field($_POST['wssmgws_daily_at'][$post_id]);

            if ($enable_manage_stock == 'no') {

                $schedule_mode = 'no';
            } elseif ($enable_manage_stock == 'on') {

                $schedule_mode = 'yes';
            }

            $monday_stock_quantity = (int) sanitize_text_field($_POST['wssmgws_monday_stock_quantity'][$post_id]);
            $tuesday_stock_quantity = (int) sanitize_text_field($_POST['wssmgws_tuesday_stock_quantity'][$post_id]);
            $wednesday_stock_quantity = (int) sanitize_text_field($_POST['wssmgws_wednesday_stock_quantity'][$post_id]);
            $thursday_stock_quantity = (int) sanitize_text_field($_POST['wssmgws_thursday_stock_quantity'][$post_id]);
            $friday_stock_quantity = (int) sanitize_text_field($_POST['wssmgws_friday_stock_quantity'][$post_id]);
            $saturday_stock_quantity = (int) sanitize_text_field($_POST['wssmgws_saturday_stock_quantity'][$post_id]);
            $sunday_stock_quantity = (int) sanitize_text_field($_POST['wssmgws_sunday_stock_quantity'][$post_id]);
        }

        update_post_meta($post_id, 'wssmgws_schedule_mode', $schedule_mode);
        update_post_meta($post_id, 'wssmgws_daily_at', date("H:i", strtotime($daily_at)));

        update_post_meta($post_id, 'wssmgws_monday_stock_quantity', $monday_stock_quantity);
        update_post_meta($post_id, 'wssmgws_tuesday_stock_quantity', $tuesday_stock_quantity);
        update_post_meta($post_id, 'wssmgws_wednesday_stock_quantity', $wednesday_stock_quantity);
        update_post_meta($post_id, 'wssmgws_thursday_stock_quantity', $thursday_stock_quantity);
        update_post_meta($post_id, 'wssmgws_friday_stock_quantity', $friday_stock_quantity);
        update_post_meta($post_id, 'wssmgws_saturday_stock_quantity', $saturday_stock_quantity);
        update_post_meta($post_id, 'wssmgws_sunday_stock_quantity', $sunday_stock_quantity);

        if ($schedule_mode == 'yes') {

            wp_clear_scheduled_hook('wssmgws_do_it_every_minute', array('post_id' => $post_id));

            wp_schedule_event(
                time(),
                'wssmgws_every_minute',
                'wssmgws_do_it_every_minute',
                array('post_id' => $post_id)
            );
        }
    }
}
