<?php
// Корзина + AJAX счётчик товаров

add_filter("woocommerce_add_to_cart_fragments", "header_add_to_cart_fragment");
function header_add_to_cart_fragment($fragments)
{
    global $woocommerce;
    ob_start();
    ?>
    <div class="cart-icon__count"><?php echo sprintf($woocommerce->cart->cart_contents_count); ?></div>
    <?php
    $fragments[".cart-icon__count"] = ob_get_clean();
    return $fragments;
}

// В корзине показывать цену со скидкой
add_filter( 'woocommerce_cart_item_price', 'woomag_change_cart_table_price_display', 30, 3 );

function woomag_change_cart_table_price_display( $price, $values, $cart_item_key ) {
    $slashed_price = $values['data']->get_price_html();
    $is_on_sale = $values['data']->is_on_sale();
    if ( $is_on_sale ) {
        $price = $slashed_price;
    }
    return $price;
}