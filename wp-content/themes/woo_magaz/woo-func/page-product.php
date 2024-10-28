<?php

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('woocommerce_before_single_product', 'woomag_wrap_single_page_start', 10);

function woomag_wrap_single_page_start()
{
?>
    <div class="woomag-single-wrap-item">

    <?php
}

add_action('woocommerce_after_single_product', 'woomag_wrap_single_page_end', 10);

function woomag_wrap_single_page_end()
{
    ?>

    </div>
<?php
}


add_action('woocommerce_before_single_product_summary', 'woomag_wrap_top_info_start', 5);

function woomag_wrap_top_info_start()
{
?>
    <div class="woomag-top-wrapper">
        <div class="woomag-top_info-wrapper">
        <?php
    }

    add_action('woocommerce_before_single_product_summary', 'woomag_wrap_top_info_end', 25);

    function woomag_wrap_top_info_end()
    {
        ?>
        </div>
    <?php
    }


    add_action('woocommerce_before_single_product_summary', 'woomag_wrap_info_start', 35);

    function woomag_wrap_info_start()
    {
    ?>
        <div class="woomag__slider-wrapper">
        <?php
    }

    add_action('woocommerce_after_single_product_summary', 'woomag_wrap_info_end', 45);

    function woomag_wrap_info_end()
    {
        ?>
        </div>
    </div>
<?php
    }




    // заголовок в карточке товара

    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    add_action('woocommerce_single_product_summary', 'add_custom_text_after_product_title', 5);
    function add_custom_text_after_product_title()
    {
        $custom_text = '';
        the_title('<h3 class="woomag_product_title">', $custom_text . '</h3>');
    }




    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 10);


    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs');
    add_action('woocommerce_after_single_product', 'woocommerce_output_product_data_tabs', 10);


    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);




    // цена на странице товара
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    add_action('woocommerce_single_product_summary', 'price_in_title_row', 5);
    function price_in_title_row()
    {
        global $product;
?>
    <div class="price_in_title_row" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
        <h3><?php echo $product->get_price_html(); ?></h3>
        <meta itemprop="price" content="<?php echo esc_attr($product->get_display_price()); ?>" />
        <meta itemprop="priceCurrency" content="<?php echo esc_attr(get_woocommerce_currency()); ?>" />
        <link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
    </div>
<?php
    }

    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta');
    add_action('woocommerce_single_product_summary', 'custom_woocommerce_template_single_meta', 10);

    function custom_woocommerce_template_single_meta()
    {
        global $product;
?>
    <?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>

        <div class="sku_inner">
            <div class="sku_item">
                <p><?php esc_html_e('SKU:', 'woocommerce'); ?></p>
                <span><?php echo ($sku = $product->get_sku()) ? $sku :  esc_html__('N/A', 'woocommerce'); ?></span>
            </div>

        <?php endif; ?>
        <?php echo wc_get_product_category_list($product->get_id(), ', ', '<span class="posted_in_cat">' . _n('Category:', 'Categories:', count($product->get_category_ids()), 'woocommerce') . ' ', '</span>'); ?>
        </div>
    <?php
    }


    add_action('woocommerce_single_product_summary', 'wrap_btns_start', 28);
    function wrap_btns_start()
    {
    ?>
        <div class="wrap-btn">
        <?php
    }

    add_action('woocommerce_single_product_summary', 'wrap_btns_end', 40);
    function wrap_btns_end()
    {
        ?>
        </div>
        <?php
    }

    //Вывод атрибутов на странице товара
    add_action('woocommerce_single_product_summary', 'productFeature', 40);

    function productFeature()
    {
        global $product;

        $attribute_names = array('pa_strana', 'pa_czvet', 'pa_materialy', 'pa_proizvoditel', 'pa_tip', 'pa_sostav');
        foreach ($attribute_names as $attribute_name) {
            $taxonomy = get_taxonomy($attribute_name);

            if ($taxonomy && !is_wp_error($taxonomy)) {
                $terms = wp_get_post_terms($post->ID, $attribute_name);
                $terms_array = array();
                if (!empty($terms)) {
                    foreach ($terms as $term) {
                        $archive_link = get_term_link($term->slug, $attribute_name);
                        $full_line = '<a href="' . $archive_link . '">' . $term->name . '</a>';
                        array_push($terms_array, $full_line);
                    }

                    echo '<div class="attribute">' . '<span>' . $taxonomy->labels->singular_name . '</span>' . ' ' . implode($terms_array) . '</div>';
                }
            }
        }
    }

    // Сопутствующие товары в карточке swiper

    add_action('woocommerce_after_single_product', 'woocommerce_cross_sells_products', 15);

    function woocommerce_cross_sells_products()
    {

        $crossell_ids = get_post_meta(get_the_ID(), '_crossell_ids');

        if (!$crossell_ids) {

            add_filter('post_class', function ($classes, $class, $product_id) {
                if (is_product()) {
                    //only add these classes if we're on a product category page.
                    $classes = array_merge(['swiper-slide', 'product-slide'], $classes);
                }
                return $classes;
            }, 10, 3);

            $crossell_ids = $crossell_ids[0];

            $args = array(
                'post_type' => 'product',
                'ignore_sticky_posts' => 1,
                'no_found_rows' => 1,
                'posts_per_page' => apply_filters('woocommerce_cross_sells_total', $posts_per_page),
                'post__in' => $crossell_ids
            );

            $products = new WP_Query($args);

            $woocommerce_loop['columns'] = apply_filters('woocommerce_cross_sells_columns', $columns);

            if ($products->have_posts()) : ?>

                <div class="cross-sells">

                    <h2 class="related-product-title"><?php _e('С этим товаром смотрят', 'woocommerce') ?></h2>

                    <div class="related-product">
                        <div class="swiper-wrapper">
                            <?php while ($products->have_posts()) : $products->the_post(); ?>

                                <?php wc_get_template_part('content', 'product'); ?>

                            <?php endwhile; // end of the loop. 
                            ?>
                        </div>
                        <div class="related-next">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 0H9C4 0 0 4 0 9V19C0 24 4 28 9 28H19C24 28 28 24 28 19V9C28 4 24 0 19 0ZM17.7 14.7L12.7 19.7C12.5 19.9 12.3 20 12 20C11.7 20 11.5 19.9 11.3 19.7C10.9 19.3 10.9 18.7 11.3 18.3L15.6 14L11.3 9.7C10.9 9.3 10.9 8.7 11.3 8.3C11.7 7.9 12.3 7.9 12.7 8.3L17.7 13.3C18.1 13.7 18.1 14.3 17.7 14.7Z" fill="#FF5710" />
                            </svg>
                        </div>
                        <div class="related-prev">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 0H9C4 0 0 4 0 9V19C0 24 4 28 9 28H19C24 28 28 24 28 19V9C28 4 24 0 19 0ZM16.7 18.3C17.1 18.7 17.1 19.3 16.7 19.7C16.5 19.9 16.3 20 16 20C15.7 20 15.5 19.9 15.3 19.7L10.3 14.7C9.9 14.3 9.9 13.7 10.3 13.3L15.3 8.3C15.7 7.9 16.3 7.9 16.7 8.3C17.1 8.7 17.1 9.3 16.7 9.7L12.4 14L16.7 18.3Z" fill="#FF5710" />
                            </svg>
                        </div>
                    </div>
                </div>

            <?php endif; ?>
        <?php
        }
        wp_reset_query();
    }

    // Отзывы

    add_action('woocommerce_single_product_summary', 'custom_rating_single_product_summary', 4);
    function custom_rating_single_product_summary()
    {
        global $product;

        if ($product->get_rating_count() > 0) {
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
            add_action('woocommerce_single_product_summary', 'replace_product_rating', 9);
        }
    }

    // For Shop and archicves pages
    add_action('woocommerce_after_shop_loop_item_title', 'custom_rating_after_shop_loop_item_title', 4);
    function custom_rating_after_shop_loop_item_title()
    {
        global $product;

        if ($product->get_rating_count() > 0) {
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
            add_action('woocommerce_after_shop_loop_item_title', 'replace_product_rating', 15);
        }
    }

    // Content function
    function replace_product_rating()
    {
        global $product;

        $rating_count = $product->get_rating_count();
        $review_count = $product->get_review_count();
        $average      = $product->get_average_rating();

        if ($rating_count > 0) {

            echo '<div class="product-rating-top-wrapper">';
            echo wc_get_rating_html($average, $rating_count);
            echo '</div>';
            //            echo '<div class="product-rating-inner">';
            //            echo '<div class="woocommerce-review_count">'. __( $review_count , "woocommerce") . '</div>';
            //            echo '<div class="woocommerce-rating_count">'. __( $rating_count , "woocommerce") . '</div>';
            //            echo '</div>';

        }
    }




    add_action('woocommerce_after_shop_loop_item_title', 'wooMag_addfavorite_btn_prod_card', 40);
    function wooMag_addfavorite_btn_prod_card()
    {

        global $post;

        if (in_array($post->ID, favorite_id_array())) { ?>
            <div class="delete_favorite" data-post_id="<?php echo $post->ID; ?>" style="max-width: 40px">
                <div class="favorite_item_list-page fv_<?php echo $post->ID; ?>" title="В избранном" data-post_id="<?php echo $post->ID; ?>">
                    <svg width="40" height="40" viewBox="0 0 128 128" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1_3219)">
                            <path d="M128 36C128 16.117 111.883 0 92 0C80.621 0 70.598 5.383 64 13.625C57.402 5.383 47.379 0 36 0C16.117 0 0 16.117 0 36C0 36.398 0.105 36.773 0.117 37.172H0C0 74.078 64 128 64 128C64 128 128 74.078 128 37.172H127.883C127.895 36.773 128 36.398 128 36ZM119.887 36.938L119.836 40.11C117.184 64.852 82.633 100.633 63.996 117.383C45.496 100.766 11.301 65.383 8.223 40.641L8.114 36.938C8.102 36.523 8.063 36.109 8 35.656C8.188 20.375 20.676 8 36 8C44.422 8 52.352 11.875 57.754 18.625L64 26.43L70.246 18.625C75.648 11.875 83.578 8 92 8C107.324 8 119.813 20.375 119.996 35.656C119.941 36.078 119.898 36.5 119.887 36.938Z" fill="black"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_1_3219">
                                <rect width="128" height="128" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </div>
            </div>
        <?php } else { ?>
            <div class="favorite_item_list-page fv_<?php echo $post->ID; ?>" style="max-width: 40px">
                <div class="add-favorite" title="В избранное" data-post_id="<?php echo $post->ID; ?>">
                    <svg width="40" height="40" viewBox="0 0 128 128" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M128 36C128 16.117 111.883 0 92 0C80.621 0 70.598 5.383 64 13.625C57.402 5.383 47.379 0 36 0C16.117 0 0 16.117 0 36C0 36.398 0.105 36.773 0.117 37.172H0C0 74.078 64 128 64 128C64 128 128 74.078 128 37.172H127.883C127.895 36.773 128 36.398 128 36ZM119.887 36.938L119.836 40.11C117.184 64.852 82.633 100.633 63.996 117.383C45.496 100.766 11.301 65.383 8.223 40.641L8.114 36.938C8.102 36.523 8.063 36.109 8 35.656C8.188 20.375 20.676 8 36 8C44.422 8 52.352 11.875 57.754 18.625L64 26.43L70.246 18.625C75.648 11.875 83.578 8 92 8C107.324 8 119.813 20.375 119.996 35.656C119.941 36.078 119.898 36.5 119.887 36.938Z" fill="#06F601"/>
                    </svg>
                </div>
            </div>
        <?php }
    }





add_action('woocommerce_after_shop_loop_item_title', 'wooMag_addcompire_btn_prod_card', 40);
function wooMag_addcompire_btn_prod_card()
{

    global $post;

    if (in_array($post->ID, compire_id_array())) { ?>
        <div class="delete_compire" data-post_id="<?php echo $post->ID; ?>">
            <div class="compire_item_list-page cp_<?php echo $post->ID; ?>" title="В Сравнении" data-post_id="<?php echo $post->ID; ?>" style="max-width: 40px">
                <svg width="40" height="40" viewBox="0 0 128 128" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="22" y="8" width="10" height="112" rx="5" fill="black"/>
                    <rect x="44" y="24" width="10" height="96" rx="5" fill="black"/>
                    <rect x="66" y="61" width="10" height="59" rx="5" fill="black"/>
                    <rect x="88" y="35" width="10" height="85" rx="5" fill="black"/>
                </svg>
            </div>
        </div>
    <?php } else { ?>
        <div class="compire_item_list-page cp_<?php echo $post->ID; ?>" style="max-width: 40px">
            <div class="add-compire" title="В сравнение" data-post_id="<?php echo $post->ID; ?>">
                <svg width="40" height="40" viewBox="0 0 128 128" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="22" y="8" width="10" height="112" rx="5" fill="#06F601"/>
                    <rect x="44" y="24" width="10" height="96" rx="5" fill="#06F601"/>
                    <rect x="66" y="61" width="10" height="59" rx="5" fill="#06F601"/>
                    <rect x="88" y="35" width="10" height="85" rx="5" fill="#06F601"/>
                </svg>
            </div>
        </div>
    <?php }
}


