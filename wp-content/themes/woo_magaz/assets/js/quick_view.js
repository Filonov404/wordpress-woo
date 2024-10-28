$(document).ready(function () {
    $("body").on("click", ".ajax-post", function (e) {
        // Показать модальное окно
        $('.popup.supernova').fadeIn();
        $('#backfon').fadeIn();

        //Скрыть модальное окно
        $('#backfon').click(function() {
            $('#backfon').fadeIn();
            $('.popup').hide()
            setTimeout(function () { $('#sea').hide(); $('#backfon').hide(); }, 700);
        });

        $('.close-popup').click(function () {
            $('.popup').hide()
            $('#backfon').fadeOut();
        });

        var post_id = $(this).attr('id'); //Get Post ID
        $.ajax({
            url: quick_view_object.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'theme_post_example',
                id: post_id,
            },

            beforeSend: function () {
                $('.ajax-response').html('Загружаем');
            },

            success: function (data, textStatus, jqXHR) {
                $('.ajax-response').html(data.product);
            },


        });
        e.preventDefault();
    });
});