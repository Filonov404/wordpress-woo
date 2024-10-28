<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories');
add_action( 'woocommerce_before_shop_loop', 'woomag_out_subcategories' ,30 );
function woomag_out_subcategories() {
    $cat_out = woocommerce_output_product_categories([
        'before'    => '<ul class="products-categories-wrapper">',
        'after'     => '</ul>',
        'parent_id' => is_product_category() ? get_queried_object_id() : 0,
    ]);
    return $cat_out;
}

add_filter( 'product_cat_class', 'woomag_add_classes_product_cat' );
function woomag_add_classes_product_cat($classes){
    $classes[] = 'product-category-wrappers';
    return $classes;
}

