$(document).ready(function () {
    $('#records-limit').change(function () {
        $('form').submit();
    })

    // new SimpleLightbox({elements: '.galeria a'});
    // galeria.show();

    // var lightbox = new SimpleLightbox({
    //     $items: $('.gallery a')
    // });
    
    // $('.post_img').click(function() {
    //     var id = $(this).attr('id').substr(6);
    //     console.log("id: "+id);
    //     $('.carousel-indicator').each(function() {
    //         if ($(this).hasClass("active")) {
    //             $(this).removeClass("active");
    //         }
    //     })
    //     $('#indicator-'+id).addClass('active');
    //     $('.carousel-item').each(function() {
    //         if ($(this).hasClass("active")) {
    //             $(this).removeClass("active");
    //         }
    //     })
    //     $('#item-'+id).addClass('active');
    //     $('#modal-galeria').modal('show');
    // })
});