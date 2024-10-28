<?php
/*
Template Name: comprire
*/
get_header();
?>

    <style>
        .add-compire {
            display: none;
        }

        .fav-wrap-cnt {
            display: flex;
            flex-wrap: wrap;
            padding: 40px 0 40px;
        }


        .compire-inner {
            position: relative;
            display: flex;
            flex-direction: column;
            max-width: 250px;
            padding: 30px 20px 10px 20px;
            border: 1px solid #ccc;
            margin: 10px;
            border-radius: 10px;
        }

        .delete_compire {
            position: absolute;
            top: 7px;
            left: 7px;
            z-index: 2;
        }

        .compire-title {
            padding-top: 20px;
            padding-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }

        .compire-link-item {
            text-align: center;
        }

        .compire-link {
            color: #08f600;
            transition: all .3s ease;
        }

        .compire-link:hover {
            color: #000;
            text-decoration: underline;
        }

        .attr-wrap {
            display: flex;
        }
    </style>
    <div class="container">
        <div class="fav-wrap-cnt">


            <?php
            $compire_id_array = compire_id_array();
            global $wp_query;
            $save_wpq = $wp_query;
            $args = array(
                'paged' => get_query_var('paged') ? absint(get_query_var('paged')) : 1,
                'post_type' => 'product',
                'post__in' => !empty($compire_id_array) ? $compire_id_array : array(0),
            );
            $wp_query = new WP_Query($args);
            ?>
            <?php if ($wp_query->have_posts()) : ?>
                <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                    <div class="compire-inner cp_<?php echo $post->ID; ?>">

                        <div class="delete_compire" data-post_id="<?php echo $post->ID; ?>"
                             title="Удалить из избранного">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20"
                                 viewBox="0 0 50 50">
                                <path d="M 7.71875 6.28125 L 6.28125 7.71875 L 23.5625 25 L 6.28125 42.28125 L 7.71875 43.71875 L 25 26.4375 L 42.28125 43.71875 L 43.71875 42.28125 L 26.4375 25 L 43.71875 7.71875 L 42.28125 6.28125 L 25 23.5625 Z"></path>
                            </svg>
                        </div>
                        <a href="<?php the_permalink() ?>">
                            <div class="product_in_favorite-item">
                                <div style="max-width: 150px">
                                    <?php the_post_thumbnail('thumbnail') ?>
                                </div>

                                <h4><?php the_title(); ?></h4>

                            </div>
                            <div class="attrs">
                                <?php

                                global $product;
                                $attributes = $product->get_attributes();

                                foreach ($attributes as $attribute) :

                                    if (empty($attribute['is_visible']) || ($attribute['is_taxonomy'] && !taxonomy_exists($attribute['name']))) {
                                        continue;

                                    } else {
                                        $has_row = true;
                                    }

                                    ?>
                                    <div class="attr-wrap">
                                        <span class="attr-name"><?php echo wc_attribute_label($attribute['name']); ?></span>:
                                        <div class="attr-value">
                                            <?php

                                            if ($attribute['is_taxonomy']) {

                                                $values = wc_get_product_terms($product->id, $attribute['name'], array('fields' => 'names'));
                                                echo apply_filters('woocommerce_attribute', wpautop(wptexturize(implode(', ', $values))), $attribute, $values);

                                            } else {

                                                // Convert pipes to commas and display values
                                                $values = array_map('trim', explode(WC_DELIMITER, $attribute['value']));
                                                echo apply_filters('woocommerce_attribute', wpautop(wptexturize(implode(', ', $values))), $attribute, $values);

                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="container">
                    <h2 class="compire-title">В сравнении пока ни чего нет</h2>
                    <div class="compire-link-item">
                        <a class="compire-link" href="/shop">Перейти</a> в магазин
                    </div>
                </div>
                <style>
                    .compire-title {
                        padding-top: 20px;
                        padding-bottom: 20px;
                        font-size: 24px;
                        text-align: center;
                    }

                    .compire-link-item {
                        text-align: center;
                    }

                    .compire-link {
                        color: #08f600;
                        transition: all .3s ease;
                    }

                    .compire-link:hover {
                        color: #000;
                        text-decoration: underline;
                    }

                    .product.woocommerce.add_to_cart_inline {
                        border: none !important;
                        padding: 0 !important;
                    }
                </style>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
<?php
get_footer();