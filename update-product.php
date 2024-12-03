<?php
/* 
Plugin Name: Update Product
Description: Update product prueba solutionweb
Version: 1.0.0
*/

require_once plugin_dir_path(__FILE__) . 'includes/global-v.php';
require_once plugin_dir_path(__FILE__) . 'includes/cron.php';
require_once plugin_dir_path(__FILE__) . 'includes/api.php';

register_activation_hook(__FILE__, ['WC_Stock', 'activate']);
register_deactivation_hook(__FILE__, ['WC_Stock', 'deactivate']);