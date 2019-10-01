$(function() {
    const scrollPos = 50;

    $("a[href='#top']").click(function(e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return false;
    });

    $(document).scroll(function(e) {
        if ($(document).scrollTop() >= scrollPos) {
            $("a[href='#top']").fadeIn();
        } else {
            $("a[href='#top']").fadeOut();
        }
    });

    if ($(document).scrollTop() >= scrollPos) {
        $("a[href='#top']").show();
    }
});