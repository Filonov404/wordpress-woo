<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Добавить класс к обёртке карточки товара в списке

add_filter( 'post_class', 'estore_add_class_loop_item' );
function estore_add_class_loop_item($clasess){
    if(is_shop() || is_product_taxonomy()){
        $clasess[] = 'product-item_in-list';
    }

    return $clasess;
}


// артикул
add_action( 'woocommerce_after_shop_loop_item_title', 'shop_sku' );
function shop_sku(){
    global $product;
    echo '<div itemprop="productID" class="sku">Артикул: ' . $product->sku . '</div>';
}


//Вывод рейтинга в звездах в карточке товара

add_filter('woocommerce_product_get_rating_html', 'your_get_rating_html', 10, 2);
function your_get_rating_html($rating_html, $rating) {
    if ( $rating > 0 ) {
        $title = sprintf( __( 'Оценка %s из 5', 'woocommerce' ), $rating );
        $rating_html  = '<div class="star-rating" title="' . $title . '">';
        $rating_html .= '<div class="rating-stars-data" style="width:' . ( ( $rating / 5 ) * 100 ) . '%">' . '</div>';
        $rating_html .= '</div>';
        $rating_html .=  '<div class="rating-count">' . $rating . '<span>' . '/5' . '</span>' . '</div>';
    } else {
        $title = 'Еще не оценено';
        $rating_html = '';
    }

    return $rating_html;
}



// наличие
add_action( 'woocommerce_shop_loop_item_title', 'action_woocommerce_after_shop_loop_item', 15);
function action_woocommerce_after_shop_loop_item() {
    global $product;
    if ($product->stock_status == 'instock') {
        echo '<div class="my_quantity">В наличии: ' . $product->stock . '</div>';
    } else {
        echo '<div class="my_quantity">' . 'Нет в наличии' . '</div>';
    }
};




add_action( 'woocommerce_shop_loop_item_title', 'wooMag_quickView_btn_prod_page', 30);

function wooMag_quickView_btn_prod_page () {

    ?>
    <a title="Быстрый просмотр" href="#" id="<?php the_ID(); ?>" class="ajax-post postview"><svg enable-background="new 0 0 512 512" height="60px" id="Layer_1" version="1.1" viewBox="0 0 512 512" width="60px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="   M256,193.4c-46.4,0-86.8,25.2-108.5,62.6c21.7,37.4,62.1,62.6,108.5,62.6c46.4,0,86.8-25.2,108.5-62.6   C342.8,218.6,302.4,193.4,256,193.4z" fill="none" stroke="#FF5710" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="10"/><circle cx="256" cy="256" fill="none" r="37.7" stroke="#FF5710" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="10"/></g></svg></a>
<?php
}

