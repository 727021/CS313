$(function() {
    $("button.copyLink").each(function() {
        $(this).click(function() {
            prompt("Share this link to your survey:", `${String(window.location).slice(0, String(window.location).lastIndexOf('/'))}/survey.php?id=${$(this).attr("data-shortcode")}`);
        });
    });
});