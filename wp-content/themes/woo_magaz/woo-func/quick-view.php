<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action( 'wp_ajax_theme_post_example', 'theme_post_example_init' );
add_action( 'wp_ajax_nopriv_theme_post_example', 'theme_post_example_init' );

function theme_post_example_init() {

$product = wc_get_product(esc_attr($_POST['id']));
//
//    echo '<pre>';
//    print_r($product);
//    echo '</pre>';

ob_start();

?>
    <div class="modal-body">
        <div class="modal_content">
            <?php
            $attachment_id = get_post_thumbnail_id( $product->get_id() );
            $product_thumb = wp_get_attachment_image_url( $attachment_id, 'thumb');
            ?>
            <img data-fancybox src="<?= $product_thumb; ?>" alt="<?php the_title();?>" class="img-responsive" />
        </div>
        <div class="modal_text">
            <h4><?= $product->get_name(); ?></h4>
            <div class="modal_quick_description">

                <p><?= $product->get_description(); ?></p>
            </div>
            <div class="modal_bottom_inner">
                <span class="price"><?php if (!$product->get_price_html()) {
                            echo $product->get_attributes();
                    } else {
                         echo $product->get_price_html();?></span>
        <?php

                    }
?>

                <?php
                printf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                    esc_url( $product->add_to_cart_url() ),
                    esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                    'button product_type_'. $product->get_type() .' add_to_cart_button ajax_add_to_cart w3ls-cart',
                    'data-product_id="' . $product->get_id() . '" data-product_sku="' . $product->get_sku() . '" aria-label="'. $product->get_description() .'"',
                    esc_html( $product->add_to_cart_text() )
                ) ?>

            </div>
        </div>
    </div>
    <?php
$data['product'] = ob_get_clean();
wp_send_json($data);
wp_die();

}




