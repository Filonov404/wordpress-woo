(function($) {

    $(function() {

        //-----------------------------------------------------
        // [2] Ajax load products - On Click
        //-----------------------------------------------------
        $('#pp_loadmore_products').click(function(){

            var button = $(this),
                data = {
                    'action': 'loadmore',
                    'query': wp_js_vars.posts, // that's how we get params from wp_localize_script() function
                    'page' : wp_js_vars.current_page
                };

            $.ajax({
                url : wp_js_vars.ajaxurl, // AJAX handler
                data : data,
                related_products : 'no',
                type : 'POST',
                beforeSend : function ( xhr ) {
                    button.addClass('preloader');
                    button.text('');
                },
                success : function( data ){
                    if( data ) {
                        //console.log('current_page: ' + wp_js_vars.current_page + ' max_page: ' + wp_js_vars.max_page);
                        $('#container_products_more .products_archive_grid').append( data ); // where to insert posts
                        button.removeClass('preloader');
                        button.text( 'Загрузить ещё' );
                        wp_js_vars.current_page++;

                        if ( wp_js_vars.current_page == wp_js_vars.max_page )
                            button.remove(); // if last page, remove the button
                    } else {
                        button.remove(); // if no data, remove the button as well
                    }
                }
            });
        });

    });
}(jQuery));