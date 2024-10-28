$(document).ready(function () {

    //adding to favorite
    $('body').on('click', '.add-favorite', function () {
        var post_id = $(this).data('post_id');
        let $this = $(this);
        $.ajax({
            url: wooeshop_wishlist_object.ajax_url,
            type: 'POST',
            data: {
                action: 'favorite',
                post_id: post_id,
            },
            beforeSend: function () {
                $('.fv_' + post_id).addClass('preloader');
            },
            success: function (data) {
                $('.fv_' + post_id).html('<div class="delete_favorite" data-post_id=' + post_id + ' title="В избранном"><svg width="40" height="40" viewBox="0 0 128 128" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1_3219)"><path d="M128 36C128 16.117 111.883 0 92 0C80.621 0 70.598 5.383 64 13.625C57.402 5.383 47.379 0 36 0C16.117 0 0 16.117 0 36C0 36.398 0.105 36.773 0.117 37.172H0C0 74.078 64 128 64 128C64 128 128 74.078 128 37.172H127.883C127.895 36.773 128 36.398 128 36ZM119.887 36.938L119.836 40.11C117.184 64.852 82.633 100.633 63.996 117.383C45.496 100.766 11.301 65.383 8.223 40.641L8.114 36.938C8.102 36.523 8.063 36.109 8 35.656C8.188 20.375 20.676 8 36 8C44.422 8 52.352 11.875 57.754 18.625L64 26.43L70.246 18.625C75.648 11.875 83.578 8 92 8C107.324 8 119.813 20.375 119.996 35.656C119.941 36.078 119.898 36.5 119.887 36.938Z" fill="black"/></g><defs><clipPath id="clip0_1_3219"><rect width="128" height="128" fill="white"/></clipPath></defs></svg></div>');
                $('.fv_' + post_id).removeClass('preloader')
                $('.num-favorite').html(data);
            },
        });
    });


    //deleting from page favorite
    $('body').on('click', '.delete_favorite', function () {
        let $this = $(this);
        var post_id = $(this).data('post_id');
        $.ajax({
            url: wooeshop_wishlist_object.ajax_url,
            type: 'POST',
            data: {
                action: 'delfavorite',
                post_id: post_id,
            },
            beforeSend: function () {
                $('.fv_' + post_id).addClass('preloader');
            },
            success: function (data) {
                $('.fv_' + post_id).html('<div class="add-favorite" title="В избранное" data-post_id="' + post_id + '"><svg width="40" height="40" viewBox="0 0 128 128" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M128 36C128 16.117 111.883 0 92 0C80.621 0 70.598 5.383 64 13.625C57.402 5.383 47.379 0 36 0C16.117 0 0 16.117 0 36C0 36.398 0.105 36.773 0.117 37.172H0C0 74.078 64 128 64 128C64 128 128 74.078 128 37.172H127.883C127.895 36.773 128 36.398 128 36ZM119.887 36.938L119.836 40.11C117.184 64.852 82.633 100.633 63.996 117.383C45.496 100.766 11.301 65.383 8.223 40.641L8.114 36.938C8.102 36.523 8.063 36.109 8 35.656C8.188 20.375 20.676 8 36 8C44.422 8 52.352 11.875 57.754 18.625L64 26.43L70.246 18.625C75.648 11.875 83.578 8 92 8C107.324 8 119.813 20.375 119.996 35.656C119.941 36.078 119.898 36.5 119.887 36.938Z" fill="#06F601"></path></svg></div>')
                $('.fv_' + post_id).removeClass('preloader')
                // $('.fv_' + post_id).html('Deleted').remove();
                $('.num-favorite').html(data);
                $(".favorite-inner.fv_"  + post_id).css('display', 'none');

            },
        });
    });
});



