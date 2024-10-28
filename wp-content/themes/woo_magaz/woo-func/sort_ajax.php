<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Удаление стандартной сортировки
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 42);

add_action('woocommerce_before_shop_loop', 'variations_table', 43);




