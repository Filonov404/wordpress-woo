jQuery(document).ready(function($) {
    $('.taguniq').click( function(event) {

        // Prevent defualt action - opening tag page
        if (event.preventDefault) {
            event.preventDefault();
        } else {
            event.returnValue = false;
        }

        // Get tag slug from title attirbute
        var selecetd_taxonomy = $(this).attr('title');
        var selecetd_cat = $('#curcat').attr('title');

        $('.tagged-posts').fadeOut();

        data = {
            action: 'filter_posts',
            afp_nonce: afp_vars.afp_nonce,
            taxonomy: selecetd_taxonomy,
            category: selecetd_cat,
        };


        $.ajax({
            type: 'post',
            dataType: 'html',
            url: afp_vars.afp_ajax_url,
            data: data,
            success: function( data, textStatus, XMLHttpRequest ) {
                $('.tagged-posts').html( data );
                $('.tagged-posts').fadeIn();
                $(".hentry").css("height", "auto");
                $(".hentry").setEqualHeight();
                console.log( textStatus );
                console.log( XMLHttpRequest );
            },
            error: function( MLHttpRequest, textStatus, errorThrown ) {

                $('.tagged-posts').html( 'No posts found' );
                $('.tagged-posts').fadeIn();
            }
        })

    });


    $('#all').click( function(event) {


        // Получаем данные из различных атрибутов
        var selecetd_cat = $('#curcat').attr('title');


        $('.tagged-posts').fadeOut();

        data = {
            action: 'filter_posts',
            afp_nonce: afp_vars.afp_nonce,
            category: selecetd_cat,
        };


        $.ajax({
            type: 'post',
            dataType: 'html',
            url: afp_vars.afp_ajax_url,
            data: data,
            success: function( data, textStatus, XMLHttpRequest ) {
                $('.tagged-posts').html( data );
                $('.tagged-posts').fadeIn();
                $(".hentry").css("height", "auto");
                $(".hentry").setEqualHeight();
                console.log( textStatus );
                console.log( XMLHttpRequest );
            },
            error: function( MLHttpRequest, textStatus, errorThrown ) {
                console.log( MLHttpRequest );
                console.log( textStatus );
                console.log( errorThrown );
                $('.tagged-posts').html( 'No posts found' );
                $('.tagged-posts').fadeIn();
            }
        })


    });

});