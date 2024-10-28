<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'veles_carbon' );
function veles_carbon() {


//    Container::make( 'post_meta', 'Первый экран страницы' )
//        ->add_fields( array(
//            Field::make( 'media_gallery', 'veles_img', 'Галерея' ),
//            Field::make( 'text', 'veles_text', 'Галерея-текст' )
//        ) );

}