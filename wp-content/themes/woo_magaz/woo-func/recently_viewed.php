<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_shortcode('recently_viewed_products', 'woomag_recently_viewed_shortcode');

function woomag_recently_viewed_shortcode()
{

    $viewed_products = !empty($_COOKIE['woocommerce_recently_viewed']) ? (array)explode('|', wp_unslash($_COOKIE['woocommerce_recently_viewed'])) : array();
    $viewed_products = array_slice($viewed_products, 0, 8);

    if (empty($viewed_products)) return;

    $title = '<h3 class="related-product-title">Вы смомтрели</h3>';
    $product_ids = implode(",", $viewed_products);

    return $title . do_shortcode("[products ids='$product_ids']");

}

// adds notice at single product page above add to cart
add_action('woocommerce_after_single_product', 'recviproducts', 31);
function recviproducts()
{
    echo do_shortcode('[recently_viewed_products]');
}

// https://github.com/woocommerce/woocommerce/issues/9724#issuecomment-160618200
function custom_track_product_view()
{
    if (!is_singular('product') || !is_cart() || is_page_template('pages-templates\favorite.php')) {
        return;
    }

    global $post;

    if (empty($_COOKIE['woocommerce_recently_viewed']))
        $viewed_products = array();
    else
        $viewed_products = (array)explode('|', $_COOKIE['woocommerce_recently_viewed']);

    if (!in_array($post->ID, $viewed_products)) {
        $viewed_products[] = $post->ID;
    }

    if (sizeof($viewed_products) > 15) {
        array_shift($viewed_products);
    }

    // Store for session only
    wc_setcookie('woocommerce_recently_viewed', implode('|', $viewed_products));
}

add_action('template_redirect', 'custom_track_product_view', 20);