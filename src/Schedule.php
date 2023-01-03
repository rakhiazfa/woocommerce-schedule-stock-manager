<?php

namespace GreatWebsiteStudio;

/**
 * Class Schedule
 * 
 * @author Great Website Studio
 */
class Schedule
{

    /**
     * Setup Schedule
     * 
     * @return Void
     */
    public static function setup()
    {

        add_filter('cron_schedules', array(self::class, 'add_intervals'));

        add_action('wssmgws_do_it_every_minute', array(self::class, 'do_it_every_minute'));
    }

    /**
     * Add Intervals
     * 
     * @param mixed $schedules
     * 
     * @return array
     */
    public static function add_intervals($schedules)
    {
        $schedules['wssmgws_every_minute'] = array(
            'interval' => 60,
            'display'  => __('Every Minute (Every 60 Second)'),
        );

        $schedules['wssmgws_every_hour'] = array(
            'interval' => 3600,
            'display'  => __('Every Hour (Every 60 Minute)'),
        );

        $schedules['wssmgws_every_day'] = array(
            'interval' => 86400,
            'display'  => __('Every Day (Every 24 Hour)'),
        );

        return $schedules;
    }

    /**
     * Do It Every Daily
     * 
     * @param mixed $post_id
     * 
     * @return void
     */
    public static function do_it_every_minute($post_id)
    {

        date_default_timezone_set(wp_timezone_string());

        $schedule_mode = get_post_meta($post_id, 'wssmgws_schedule_mode', true);
        $daily_at = get_post_meta($post_id, 'wssmgws_daily_at', true);

        $monday_stock_quantity = (int) get_post_meta($post_id, 'wssmgws_monday_stock_quantity', true);
        $tuesday_stock_quantity = (int) get_post_meta($post_id, 'wssmgws_tuesday_stock_quantity', true);
        $wednesday_stock_quantity = (int) get_post_meta($post_id, 'wssmgws_wednesday_stock_quantity', true);
        $thursday_stock_quantity = (int) get_post_meta($post_id, 'wssmgws_thursday_stock_quantity', true);
        $friday_stock_quantity = (int) get_post_meta($post_id, 'wssmgws_friday_stock_quantity', true);
        $saturday_stock_quantity = (int) get_post_meta($post_id, 'wssmgws_saturday_stock_quantity', true);
        $sunday_stock_quantity = (int) get_post_meta($post_id, 'wssmgws_sunday_stock_quantity', true);

        $map = array(
            'monday' => $monday_stock_quantity,
            'tuesday' => $tuesday_stock_quantity,
            'wednesday' => $wednesday_stock_quantity,
            'thursday' => $thursday_stock_quantity,
            'friday' => $friday_stock_quantity,
            'saturday' => $saturday_stock_quantity,
            'sunday' => $sunday_stock_quantity,
        );

        if ($schedule_mode == 'yes') {

            $now = date('l');

            if (date('H:i') == $daily_at) {

                wc_update_product_stock($post_id, $map[strtolower($now)]);
            }
        }
    }
}
