<?php
/*
Template Name: Главная
*/
?>

<?php get_header(); ?>
<main>


    <div class="row">
        <?php
        // Выполнение запроса по категориям и атрибутам
        $args = array(
// Использование аргумента tax_query для установки параметров терминов таксономии
            'tax_query' => array(
// Использование нескольких таксономий требует параметр relation
                'relation' => 'AND', // значение AND для выборки товаров принадлежащим одновременно ко всем указанным терминам
// массив для категории имеющей слаг slug-category-1
                array(
                    'taxonomy' => 'pa_brend',
                    'field' => 'slug',
                )
            ),
// Параметры отображения выведенных товаров
            'posts_per_page' => 4, // количество выводимых товаров
            'post_type' => 'product', // тип товара
            'orderby' => 'title', // сортировка
        );
        $loop = new WP_Query($args);
        while ($loop->have_posts()) : $loop->the_post();
            global $product;
            ?>
            <!-- Цикл для вывода выбранных товаров -->
            <figure class="col-sm-3 product">
                <a href="<?php echo get_permalink($loop->post->ID) ?>">
                    <?php woocommerce_show_product_sale_flash($post, $product); ?>
                    <?php
                    if (has_post_thumbnail($loop->post->ID)) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog');
                    else echo '<img src="' . woocommerce_placeholder_img_src() . '" alt="Placeholder" width="250px" height="250px" />';
                    ?>
                </a>
                <figcaption>
                    <h3 class="product-title"><?php the_title(); ?></h3>
                    <div class="product-price"><?php echo $product->get_price_html(); ?></div>
                    <div class="text-center">
                        <?php woocommerce_template_loop_add_to_cart($loop->post, $product); ?>
                    </div>
                </figcaption>
            </figure>
        <?php endwhile; ?>
        <!-- Сброс данных запроса -->
        <?php wp_reset_query(); ?>
    </div>

    <?php
//    $terms = get_terms(array(
//        'taxonomy' => 'pa_brend',
//        'hide_empty' => false,
//        'meta_query' => array(
//            'key' => 'kartinka_dlya_brenda',
//        )
//    ));
//
//    foreach ($terms as $term) {
//        $term_name = $term->name;
//        $term_url = get_term_link($term);
//        foreach ($term->children as $child) {
//            $term_name = $child->name;
//        }
//        echo "<a href='$term_url'>$term_name</a><br>";
////        echo "<pre>";
////        print_r($term);
////        echo "<pre>";
//
//    }

    //echo do_shortcode('[pwb-all-brands image_size="thumbnail" hide_empty="true"]');
    ?>

<?php


    ?>

    <!--    --><?php
    //    //получаем первое значение из массива значений атрибута. Если нужно выводить поля нескольких значений, убираем [0] и в дальнейшем используем цикл
    //    global $product;
    //    $brand = get_terms($product->id, 'pa_brend')[0]; ?>
    <!---->
    <!---->
    <!--    --><?php //if (get_field('kartinka_dlya_brenda', $brand)): ?>
    <!--        <img src="--><?php //echo get_field('kartinka_dlya_brenda', $brand); ?><!--" alt="логотип бренда">-->
    <!--    --><?php //endif; ?>


</main>

</body>
</html>

<?php get_footer(); ?>

           