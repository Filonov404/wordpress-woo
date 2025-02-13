<?php

add_action('woocommerce_before_add_to_cart_button', 'woomag_add_quantity_wrap');

function woomag_add_quantity_wrap() {
    echo '<div class="btn_increment-quantity">';
}


add_action( 'woocommerce_after_add_to_cart_quantity', 'ts_quantity_plus_sign' );

function ts_quantity_plus_sign() {
    echo '<button type="button" class="plus" >+</button>';
    echo '</div>';
}

add_action( 'woocommerce_before_add_to_cart_quantity', 'ts_quantity_minus_sign' );

function ts_quantity_minus_sign() {
    echo '<button type="button" class="minus" >-</button>';

}

add_action( 'wp_footer', 'ts_quantity_plus_minus' );

function ts_quantity_plus_minus() {
// To run this on the single product page
    if ( ! is_product() ) return;
    ?>
    <script type="text/javascript">

        jQuery(document).ready(function($){

            $('form.cart').on( 'click', 'button.plus, button.minus', function() {

// Get current quantity values
                var qty = $( this ).closest( 'form.cart' ).find( '.qty' );
                var val = parseFloat(qty.val());
                var max = parseFloat(qty.attr( 'max' ));
                var min = parseFloat(qty.attr( 'min' ));
                var step = parseFloat(qty.attr( 'step' ));

// Change the value if plus or minus
                if ( $( this ).is( '.plus' ) ) {
                    if ( max && ( max <= val ) ) {
                        qty.val( max );
                    }
                    else {
                        qty.val( val + step );
                    }
                }
                else {
                    if ( min && ( min >= val ) ) {
                        qty.val( min );
                    }
                    else if ( val > 1 ) {
                        qty.val( val - step );
                    }
                }

            });

        });

    </script>
    <?php
}