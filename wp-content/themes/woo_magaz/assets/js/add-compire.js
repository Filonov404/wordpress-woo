$(document).ready(function () {

    //adding to compire
    $('body').on('click', '.add-compire', function() {
        console.log('1');
        
        var post_id = $(this).data('post_id');
        $.ajax({
            url: add_compire_object.ajax_url,
            type: 'POST',
            data: {
                action: 'compire',
                post_id: post_id,
            },
            beforeSend: function() {
                $('.cp_' + post_id).addClass('preloader');
            },
            success: function(data) { 
                $('.cp_' + post_id).html('<div class="delete_compire" data-post_id="' + post_id + '" title="В сравнении"><svg width="40" height="40" viewBox="0 0 128 128" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="22" y="8" width="10" height="112" rx="5" fill="black"></rect><rect x="44" y="24" width="10" height="96" rx="5" fill="black"></rect><rect x="66" y="61" width="10" height="59" rx="5" fill="black"></rect><rect x="88" y="35" width="10" height="85" rx="5" fill="black"></rect></svg></div>');
                $('.cp_' + post_id).removeClass('preloader')
                $('.num-compire').html(data);
            },
        });
    });

    

    //deleting from page compire
    $('body').on('click', '.delete_compire', function() {
        var post_id = $(this).data('post_id');
        $.ajax({
            url: add_compire_object.ajax_url,
            type: 'POST',
            data: {
                action: 'delcompire',
                post_id: post_id,
            },
            beforeSend: function() {
                $('.cp_' + post_id).addClass('preloader');
            },
            success: function(data) {
                $('.cp_' + post_id).html('<div class="add-compire" title="В сравнение" data-post_id="' + post_id + '"><svg width="40" height="40" viewBox="0 0 128 128" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="22" y="8" width="10" height="112" rx="5" fill="#06F601"></rect><rect x="44" y="24" width="10" height="96" rx="5" fill="#06F601"></rect><rect x="66" y="61" width="10" height="59" rx="5" fill="#06F601"></rect><rect x="88" y="35" width="10" height="85" rx="5" fill="#06F601"></rect></svg></div>')
                $('.cp_' + post_id).removeClass('preloader')
                $('.num-compire').html(data);
                $(".compire-inner.cp_"  + post_id).css('display', 'none');

            },
        });
    });



});
