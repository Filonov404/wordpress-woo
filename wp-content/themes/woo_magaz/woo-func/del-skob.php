<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function filter_woocommerce_subcategory_count_html ( $html, $category ) {
    $html =  '<mark class="count">' . esc_html( $category->count ) . '</mark>';
    return $html;
}
add_filter( 'woocommerce_subcategory_count_html', 'filter_woocommerce_subcategory_count_html', 10, 2 );


