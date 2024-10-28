$(document).ready(function () {

    $(document).mouseup(function (e) {
        var modal = $(".modal-wrapper");
        if (e.target !== modal[0] && modal.has(e.target).length === 0) {
            $(".overlay-modal").fadeOut();
        }
    });

    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $(".catalog-list-item").addClass('cat_scroll');
            } else {
                $(".catalog-list-item").removeClass('cat_scroll');
            }
        });

        $(".scrollUp").click(function (e) {
            $("html, body").animate({"scrollTop": 0}, 100);
            e.preventDefault(e);
        });
    });

    new Swiper(".related-product", {
        loop: true,
        slidesPerView: 4,
        spaceBetween: 10,
        navigation: {
            nextEl: ".related-next",
            prevEl: ".related-prev",
        },
        autoplay: {
            delay: 3000,
        },
    });


    /*                активируем плагин Noty от обработчика CF7,  скрываем форму                   */



});

// Меню каталога

$(".category-menu-btn").click(function () {
    $(".cat_burger").toggleClass('open-burger');
    $(".category_inner").toggleClass('open-category');
});

$(".category_top_list").click(function () {
    $(".category_children_list").toggleClass('open-sub-menu');
});



function myFunction(x) {
    if (x.matches) {
        $('.category_top_list li h4').on('click', function () {
            $(this).next().slideToggle();
            $(this).toggleClass('active');
        });
        $('.category_children_list').addClass("hide");
    } else {
        $('.category_children_list').removeClass("hide");
    }
}

const menuHideRes = window.matchMedia("(max-width: 768px)");
myFunction(menuHideRes);
menuHideRes.addListener(myFunction);


// логика работы поиска аякс

$("input#keyword").keyup(function () {
    if ($(this).val().length > 2) {
        $("#datafetch").show();
    } else if ($(this).val().length === 0) {
        $("#datafetch").hide();
    } else {
        document.addEventListener('click', function () {
            $("#datafetch").hide();
            $("#keyword").val('');
        })
    }

    /* Custom Shop Filter */


    $('.plus').on('click', function(e) {
        var val = parseInt($(this).prev('input').val());
        $(this).prev('input').attr( 'value', val+1 );
    });

    $('.minus').on('click', function(e) {
        var val = parseInt($(this).next('input').val());
        if (val !== 0) {
            $(this).next('input').val( val-1 );
        }
    });




});
