<?php
class WC_Stock {
    public static function activate() {
        if (!wp_next_scheduled('update_product_stock_event')) {
            wp_schedule_event(time(), 'five_minutes', 'update_product_stock_event');
        }
    }
    public static function deactivate() {
        wp_clear_scheduled_hook('update_product_stock_event');
    }
    public static function cron_schedule($schedules) {
        $schedules['five_minutes'] = [
            'interval' => 300,
            'display'  => __('Five Minutes')
        ];
        return $schedules;
    }
}
add_filter('cron_schedules', ['WC_Stock', 'cron_schedule']);