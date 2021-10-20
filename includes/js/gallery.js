$(document).ready(function () {
    $('.carousel').on('slide.bs.carousel', function(e) {
        $(this).find('.carousel-inner').animate({
            height: $(e.relatedTarget).height()
        }, 300);
    });
    $('#records-limit').change(function () {
        $('form').submit();
    })
    
    $('.post_img').click(function() {
        var id = $(this).attr('id').substr(6);
        console.log("id: "+id);
        $('.carousel-indicator').each(function() {
            if ($(this).hasClass("active")) {
                $(this).removeClass("active");
            }
        })
        $('#indicator-'+id).addClass('active');
        $('.carousel-item').each(function() {
            if ($(this).hasClass("active")) {
                $(this).removeClass("active");
            }
        })
        $('#item-'+id).addClass('active');
        // $(".carousel-item > img").css("max-height", window.innerHeight*0.85);
        $('#modal-galeria').modal('show');
    })
});