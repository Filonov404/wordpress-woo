<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('woocommerce_before_main_content', 'woomag_main_content_container_wrapper', 3);

function woomag_main_content_container_wrapper()
{
    echo '<div class="container">';
}


add_action('woocommerce_after_main_content', 'test2_foo', 3);
function test2_foo()
{
    echo '</div>';
}


add_action('woocommerce_before_cart', 'woomag_add_wrap_cart_page');
function woomag_add_wrap_cart_page()
{
    echo '<div class="container">';
}

add_action('woocommerce_after_cart', 'woomag_add_wrap_cart_page');
function woomag_add_endwrap_cart_page()
{
    echo '</div>';
}

