$('#navcol-1').on('show.bs.collapse' ,function () {
    console.log("showing navbar");
    if (is_index_page) {
        $(".navbar").addClass("nav-solid");
        $(".navbar").removeClass("nav-transparent");
        $(".navbar-toggler-icon").css("background-image", "url('/includes/img/menu-black.svg'")
        $(".index-image-container").css("margin-top", "0px");
    }
})

$('#navcol-1').on('hide.bs.collapse', function () {
    console.log("hiding navbar");
    if (is_index_page) {
        $(".navbar").addClass("nav-transparent");
        $(".navbar").removeClass("nav-solid");
        $(".navbar-toggler-icon").css("background-image", "url('/includes/img/menu-white.svg'")
        $(".index-image-container").css("margin-top", "-87px");
    }
})