$(document).ready(function() {
    $(window).on("scroll", function() {
            if($(window).scrollTop()) {
                $('.header').addClass('nav-solid');
                $('.header').removeClass('nav-transparent');
            }
            else {
                $('.header').addClass('nav-transparent');
                $('.header').removeClass('nav-solid');
            }
    });
    // $('.header').on('shown.bs.collapse', function() {
    //     $('.header').addClass('nav-solid');
    //     $('.header').removeClass('nav-transparent');
    // });

    // $('.header').on('hidden.bs.collapse', function() {
    //     if($(window).scrollTop()) {
    //             $('.header').addClass('nav-solid');
    //             $('.header').removeClass('nav-transparent');
    //         }
    //         else {
    //             $('.header').addClass('nav-transparent');
    //             $('.header').removeClass('nav-solid');
    //         } 
    // });
});