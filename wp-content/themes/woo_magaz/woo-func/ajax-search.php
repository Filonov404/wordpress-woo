<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


// ajax fetch function
add_action( 'wp_footer', 'ajax_fetch' );
function ajax_fetch() {
    ?>
    <script type="text/javascript">
        function fetch(){
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: { action: 'data_fetch', keyword: jQuery('#keyword').val(), pcat: jQuery('#cat').val() },
                beforeSend: function () {
                    $('#keyword').html('<img src="<?php echo get_template_directory_uri() ?>/> . /images/icons/Preloader.svg">')
                },
                success: function(data) {
                    jQuery('#datafetch').html( data );
                }
            });
        }
    </script>
    <?php
}

// the ajax function
add_action('wp_ajax_data_fetch', 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch', 'data_fetch');
function data_fetch(){
    if ($_POST['pcat']) {
        $product_cat_id = array(esc_attr( $_POST['pcat'] ));
    }else {
        $terms = get_terms( 'product_cat' );
        $product_cat_id = wp_list_pluck( $terms, 'term_id' );
    }
    $the_query = new WP_Query(
        array(
            'posts_per_page' => 100,
            's' => esc_attr( $_POST['keyword'] ),
            'post_type' => array('product'),

            'tax_query' => array(
                array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'term_id',
                    'terms'     => $product_cat_id,
                    'operator'  => 'IN',
                )
            )
        )
    );
    if( $the_query->have_posts() ) :
        echo '<ul>';
        while( $the_query->have_posts() ): $the_query->the_post(); ?>
            <li>
                <a href="<?php echo esc_url( post_permalink() ); ?>">
                    <div class="search_result-item">
                        <?php the_post_thumbnail('thumbnail')?>
                        <span><?php the_title();?></span>
                    </div>
                </a>
            </li>
        <?php endwhile;
        echo '</ul>';
        wp_reset_postdata();
    endif;

    wp_die();
}
