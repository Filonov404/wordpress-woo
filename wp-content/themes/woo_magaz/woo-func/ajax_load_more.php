<?php

add_action( 'wp_enqueue_scripts', 'pp_custom_scripts_enqueue' );
function pp_custom_scripts_enqueue() {

    wp_register_script( 'woocommerce_load_more', get_stylesheet_directory_uri() . '/scripts/load_more.js', array( 'jquery' ), null, true);
    wp_enqueue_script('woocommerce_load_more');

    global $wp_query;

    $localize_var_args = array(
        'posts' => json_encode( $wp_query->query_vars ),
        'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
        'max_page' => $wp_query->max_num_pages,
        'ajaxurl' => admin_url( 'admin-ajax.php' )

    );
    wp_localize_script( 'woocommerce_load_more', 'wp_js_vars', $localize_var_args );

}


add_action('wp_ajax_loadmore', 'pp_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_loadmore', 'pp_loadmore_ajax_handler');
function pp_loadmore_ajax_handler(){


    $args = json_decode( stripslashes( $_POST['query'] ), true );
    $args['paged'] = $_POST['page'] + 1;
    $args['post_status'] = 'publish';

    query_posts( $args );

    if( have_posts() ) :

        while( have_posts() ): the_post();

            wc_get_template_part( 'content', 'product' );

        endwhile;

    endif;
    die;

}

remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 'pp_woocommerce_products_load_more', 9 );

function pp_woocommerce_products_load_more(){

    global $wp_query;

    echo '<div id="container_products_more">';
    woocommerce_product_loop_start();
    woocommerce_product_loop_end();
    //echo '<pre>' . var_export($wp_query, true) . '</pre>'; // For testing
    if (  $wp_query->max_num_pages > 1 ) {
        echo '<div id="pp_loadmore_products" class="load_more_button">Загрузить ещё</div>';
    }
    echo '</div>';

}


function woocommerce_product_loop_start() { echo '<ul class="products products_archive_grid">'; }
function woocommerce_product_loop_end() { echo '</ul>'; }
