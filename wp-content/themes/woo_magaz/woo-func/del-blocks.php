<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

add_action( 'after_setup_theme', 'remove_product_result_count', 99 );
function remove_product_result_count() {
    remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
    remove_action( 'woocommerce_after_shop_loop' , 'woocommerce_result_count', 20 );
}




