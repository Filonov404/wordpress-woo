<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
</head>
<body>

<div id="backfon"></div>
<div class="popup supernova">
    <div class="close-popup"></div>
    <div class="ajax-response"></div>
</div>

<header class="header">
    <div class="container">
        <div class="header-wrapper">
            <div class="burger-mobile">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <a href="<?= home_url() ?>" class="logo">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/icons/Logo.svg" alt="ооо Магазин">
            </a>
            <a href="<?= home_url() ?>" class="logo-min">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/icons/logo-min.svg" alt="ооо Магазин">
            </a>
            <div class="info-content">
                <div class="search_bar">
                    <form action="/" method="get" autocomplete="off" id="product_search">
                        <input class="input_search" type="text" name="s" placeholder="Поиск..." id="keyword"
                               onkeyup="fetch()">
                    </form>
                    <div class="search_result" id="datafetch">
                        <ul>
                            <li><img src="<?php bloginfo('template_url'); ?>/assets/images/icons/Preloader.svg" alt="">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="header-phone">
                <div class="phone-num">
                    <a href="tel:+790000000" class="phone-link">+7 (900) 300-00-00</a>
                </div>
            </div>
            <div class="catalog-list-item">
                <a href="<?php echo get_permalink(get_page_by_path('sravnenie')) ?>">
                    <div class="comrire">
                        <div class="num-compire"><?php echo count(compire_id_array()); ?></div>
                    </div>
                </a>
                <a href="<?php echo get_permalink(get_page_by_path('izbrannoe')) ?>">
                    <div class="favorite">
                        <div class="num-favorite"><?php echo count(favorite_id_array()); ?></div>
                    </div>
                </a>
                <?php if (!is_cart()) : ?>
                    <div class="mini-cart">
                        <?= estore_woocommerce_cart_link(); ?>
                        <div class="mini-card-content">
                            <?php the_widget('WC_Widget_Cart', ''); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="header-bottom-wrapper">
        <div class="container">
            <div class="header-bottom-inner">
                <div class="category-menu-btn">
                    <div class="cat_burger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <p>Каталог</p>
                </div>
                <div class="category_inner">
                    <?php
                    $args = array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => false,
                        'parent' => 0

                    );
                    $product_cat = get_terms($args);

                    foreach ($product_cat as $parent_product_cat) {

                        echo '
                   
                    <ul class="category_top_list">
                        <li><h4><a href="' . get_term_link($parent_product_cat->term_id) . '">' . $parent_product_cat->name . '  ' . $parent_product_cat->count . '</a><div class="open-close-category-mobile"><svg width="14" height="11" viewBox="0 0 19 11" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1.00567 0.00408936C1.13728 0.00332832 1.26774 0.028553 1.38958 0.0783176C1.51142 0.128082 1.62223 0.201409 1.71567 0.29409L9.00567 7.59409L16.2957 0.29409C16.484 0.105786 16.7394 -1.90735e-06 17.0057 -1.90735e-06C17.272 -1.90735e-06 17.5274 0.105786 17.7157 0.29409C17.904 0.482394 18.0098 0.737787 18.0098 1.00409C18.0098 1.27039 17.904 1.52578 17.7157 1.71409L9.71567 9.71409C9.62271 9.80782 9.51211 9.88221 9.39025 9.93298C9.26839 9.98375 9.13769 10.0099 9.00567 10.0099C8.87366 10.0099 8.74296 9.98375 8.6211 9.93298C8.49924 9.88221 8.38864 9.80782 8.29568 9.71409L0.295675 1.71409C0.201946 1.62113 0.12755 1.51053 0.0767822 1.38867C0.0260143 1.26681 -0.000123978 1.1361 -0.000123978 1.00409C-0.000123978 0.872078 0.0260143 0.741372 0.0767822 0.619513C0.12755 0.497653 0.201946 0.387053 0.295675 0.29409C0.389116 0.201409 0.499929 0.128082 0.621767 0.0783176C0.743605 0.028553 0.874067 0.00332832 1.00567 0.00408936Z" fill="#696969"/>
</svg>
</div></h4>
                            <ul class="category_children_list">';
                        $child_args = array(
                            'taxonomy' => 'product_cat',
                            'hide_empty' => false,
                            'parent' => $parent_product_cat->term_id
                        );
                        $child_product_cats = get_terms($child_args);
                        foreach ($child_product_cats as $child_product_cat) {
                            echo '<li><a href="' . get_term_link($child_product_cat->term_id) . '">' . $child_product_cat->name . '</a> ' . $child_product_cat->count . ' </li>';
                        }

                        echo '</ul>
                         </li>
                    </ul>';
                    }
                    ?>
                </div>
                <button class="close-menu">&times;</button>
                <nav class="header-nav">
                    <?php wp_nav_menu([
                        'theme_location' => 'top',
                        'container' => null,
                        'menu_id' => 'menu-list',
                    ]); ?>
                </nav>
            </div>
        </div>
    </div>
</header>


