<?php

function modify_woocommerce_before_shop_loop() {
    remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
    add_action( 'woocommerce_before_subcategory_title', 'change_woocommerce_subcategory_thumbnail', 10 );
}
add_action( 'woocommerce_before_shop_loop', 'modify_woocommerce_before_shop_loop' );

function change_woocommerce_subcategory_thumbnail( $category ) {
    global $wpdb;
    $small_thumbnail_size = apply_filters( 'subcategory_archive_thumbnail_size', 'woocommerce_thumbnail' );
    $dimensions           = wc_get_image_size( $small_thumbnail_size );
    // Get the latest product from the category
    $product = $wpdb->get_row("SELECT 
        ID FROM $wpdb->posts p
        JOIN $wpdb->term_relationships tr ON (p.ID = tr.object_id)
        JOIN $wpdb->term_taxonomy tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
        JOIN $wpdb->terms t ON (tt.term_id = t.term_id)
        WHERE p.post_type='product'
        AND p.post_status = 'publish'
        AND tt.taxonomy = 'product_cat'
        AND t.term_id = $category->term_id
        ORDER BY post_date DESC LIMIT 2");


    if( $product ) {
        $thumbnail_id         = get_post_meta( $product->ID, '_thumbnail_id', true );
    }else {
        $thumbnail_id         = get_term_meta( $category->term_id, 'thumbnail_id', true );
    }

    if ( $thumbnail_id ) {
        $image        = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size );
        $image        = $image[0];
        $image_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $thumbnail_id, $small_thumbnail_size ) : false;
        $image_sizes  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $thumbnail_id, $small_thumbnail_size ) : false;
    } else {
        $image        = wc_placeholder_img_src();
        $image_srcset = false;
        $image_sizes  = false;
    }

    if ( $image ) {
        // Prevent esc_url from breaking spaces in urls for image embeds.
        // Ref: https://core.trac.wordpress.org/ticket/23605.
        $image = str_replace( ' ', '%20', $image );

        // Add responsive image markup if available.
        if ( $image_srcset && $image_sizes ) {
            echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" srcset="' . esc_attr( $image_srcset ) . '" sizes="' . esc_attr( $image_sizes ) . '" />';
        } else {
            echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" />';
        }
    }
}