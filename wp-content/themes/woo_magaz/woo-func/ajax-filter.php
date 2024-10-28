<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_action('woocommerce_before_shop_loop', 'ajax_filter_wrap', 30);

function ajax_filter_wrap() {
    echo '<div class="main-content_wrapper">';
}

add_action('woocommerce_before_shop_loop', 'ajax_filter', 40);

function ajax_filter () {

    echo '<div class="filter_wrapper">';
    echo  do_shortcode( '[br_filters_group group_id=9172]' );
    echo '</div>';
}

add_action('woocommerce_before_shop_loop', 'main_content_grid_wrapper', 41);

function main_content_grid_wrapper() {
    echo '<div class="main-content-grid-wrapper">';
}