<?php
add_action('after_setup_theme', 'add_menu');
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('googleapis', 'https://fonts.googleapis.com');
    wp_enqueue_style('gstatic', 'https://fonts.gstatic.com');
    wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css2?family=Inter+Tight:wght@500;600&family=M+PLUS+Rounded+1c:wght@500&family=Poppins:wght@300;400;600&display=swap');
    wp_enqueue_style('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css');
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css');
    wp_enqueue_style('noty', 'https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.css');
    wp_enqueue_style('reset', get_template_directory_uri() . '/assets/css/reset.css');
    // wp_enqueue_style('favorite', get_template_directory_uri() . '/assets/css/favorite.css');
    wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css');

    wp_deregister_script('jquery');
    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js');

    wp_enqueue_script('jquery');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js');
    wp_enqueue_script('before-after-slider', 'https://cdn.jsdelivr.net/npm/before-after-slider@latest/dist/slider.bundle.js');
    wp_enqueue_script('noty-js', 'https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js');
    wp_enqueue_script('fancybox-js', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js');
    wp_enqueue_script('wooeshop-main', get_template_directory_uri() . '/assets/js/add-favorite.js', array('jquery'), 'null', true);
    wp_enqueue_script('add-compire', get_template_directory_uri() . '/assets/js/add-compire.js', array('jquery'), 'null', true);
    wp_enqueue_script('quick_view', get_template_directory_uri() . '/assets/js/quick_view.js', array('jquery'), 'null', true);


    wp_localize_script('quick_view', 'quick_view_object', array(
        'ajax_url'   => admin_url('admin-ajax.php'),
    ));

    wp_enqueue_script('woocommerce_load_more', get_stylesheet_directory_uri() . '/assets/js/load_more.js', array('jquery'), 'null', true);


    wp_localize_script('wooeshop-main', 'wooeshop_wishlist_object', array(
        'ajax_url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('wooeshop_wishlist_nonce'),
    ));
    wp_localize_script('add-compire', 'add_compire_object', array(
        'ajax_url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('add_compire_nonce'),
    ));
    wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), 'null', true);
});

require('inc/carbon-fields.php');
require('inc/wp-reset.php');

add_theme_support('post-thumbnails');
add_theme_support('title-tag');

function add_menu()
{
    register_nav_menu('top', 'Верхнее меню');
    register_nav_menu('bottom', 'Нижнее меню');
    register_nav_menu('categories', 'Категории');
}

add_filter('nav_menu_link_attributes', 'filter_nav_menu_link_attributes', 10, 4);

function filter_nav_menu_link_attributes($atts, $item, $args)
{
    if ($args->theme_location === 'top') {
        $atts['class'] = 'menu-list';
    }
    if ($args->theme_location === 'bottom') {
        $atts['class'] .= 'footer-link';
    }
    if ($args->theme_location === 'categories') {
        $atts['class'] .= 'cat-link';
    }
    return $atts;
}

//настройки админки woocommerce

function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce', array(
        'single_image_width' => 500,
        'product_grid' => array(
            'default_rows' => 3,
            'min_rows' => 2,
            'max_rows' => 8,
            'default_columns' => 4,
            'min_columns' => 2,
            'max_columns' => 5,
        ),
    ));
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

add_filter('woocommerce_single_product_carousel_options', 'filter_single_product_carousel_options');
function filter_single_product_carousel_options($options)
{
    $options['directionNav'] = true;

    if (wp_is_mobile()) {
        $options['smoothHeight'] = true; // Already "true" by default
        $options['controlNav'] = true; // Option 'thumbnails' by default
        $options['animation'] = "slide"; // Already "slide" by default
        $options['slideshow'] = false; // Already "false" by default
    }
    return $options;
}

add_action('after_setup_theme', 'mytheme_add_woocommerce_support');

require('woo-func/add-wrap-container.php'); // Добавление контейнера на странице с товарами и категориями
require('woo-func/del-blocks.php'); // Удаление блоков в хедере
require('woo-func/change-breadcrumps.php'); // смена класов у хлеб.крош
require('woo-func/del-skob.php'); // удаление скобок у кол-ва элементов
require('woo-func/add-wrap-cat-prod.php'); // добавление обёртки для категорий
require('woo-func/wigets.php'); // добавление виджетов в админке
require('woo-func/replace_std_category_img.php'); // Замена пустого изображения категории на последнее изображение товара

require('woo-func/small-cart.php');  // Добавление в корзину в хедере
require('woo-func/ajax-search.php'); // аякс поиск
require('woo-func/quick-view.php'); // Быстрай просмотр к.т

require('woo-func/add-favorite.php'); // Добавление в избранное
require('woo-func/add-compire.php'); // Добавление в сравнение
require('woo-func/recently_viewed.php'); // Ранне просмотреные товары

require('woo-func/del_all-prrod.php'); // Удалить все элементы в корзине
require('woo-func/add_to_cart_incremnt_btn.php'); // Удалить все элементы в корзине

require('woo-func/produkt-card.php'); // Карточка товара в списке
require('woo-func/page-product.php'); // страница товаров
require('woo-func/ajax-filter.php'); // Фильтр на аякс
require('woo-func/ajax_load_more.php'); // загрузить еще товары на аякс
require('woo-func/sort_ajax.php'); // Сортировать по на аякс

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

//поля в форме заказа WooCommerce необязательны.

add_filter('woocommerce_checkout_fields', 'no_required_checkout_fields');
function no_required_checkout_fields($fields)
{
    $fields['billing']['billing_last_name']['required'] = false;
    $fields['billing']['billing_address_1']['required'] = false;
    $fields['billing']['billing_city']['required'] = false;
    $fields['billing']['billing_postcode']['required'] = false;
    return $fields;
}

add_action('woocommerce_before_shop_loop', 'woomag_add_category_list', 30);

function woomag_add_category_list() {}

//кастомная вкладка

add_filter('woocommerce_product_tabs', 'bbloomer_add_product_tab', 9999);

function bbloomer_add_product_tab($tabs)
{
    $tabs['docs'] = array(
        'title' => __('Docs', 'woocommerce'), // TAB TITLE
        'priority' => 50, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
        'callback' => 'bbloomer_docs_product_tab_content', // TAB CONTENT CALLBACK
    );
    return $tabs;
}

function bbloomer_docs_product_tab_content()
{
    global $product;
    echo get_field('dokumentacziya');
}



add_filter( 'woocommerce_product_tabs', 'woo_custom_product_tabs' );
function woo_custom_product_tabs( $tabs ) {

    // 1) Removing tabs

    unset( $tabs['description'] );              // Remove the description tab
    // unset( $tabs['reviews'] );               // Remove the reviews tab
    unset( $tabs['additional_information'] );   // Remove the additional information tab


    // 2 Adding new tabs and set the right order

    //Attribute Description tab
    $tabs['attrib_desc_tab'] = array(
        'title'     => __( 'Desc', 'woocommerce' ),
        'priority'  => 100,
        'callback'  => 'woo_attrib_desc_tab_content'
    );

    // Adds the qty pricing  tab
    $tabs['qty_pricing_tab'] = array(
        'title'     => __( 'Quantity Pricing', 'woocommerce' ),
        'priority'  => 110,
        'callback'  => 'woo_qty_pricing_tab_content'
    );

    // Adds the other products tab
    $tabs['other_products_tab'] = array(
        'title'     => __( 'Other Products', 'woocommerce' ),
        'priority'  => 120,
        'callback'  => 'woo_other_products_tab_content'
    );

    return $tabs;

}

// New Tab contents

function woo_attrib_desc_tab_content() {
    // The attribute description tab content
    echo '<h2>Description</h2>';
    echo '<p>Custom description tab.</p>';
}
function woo_qty_pricing_tab_content() {
    // The qty pricing tab content
    echo '<h2>Quantity Pricing</h2>';
    echo '<p>Here\'s your quantity pricing tab.</p>';
}
function woo_other_products_tab_content() {
    // The other products tab content
    echo '<h2>Other Products</h2>';
    echo '<p>Here\'s your other products tab.</p>';
}