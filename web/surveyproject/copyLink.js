$(function() {
    $("button.copyLink").each(function() {
        $(this).click(function() {
            prompt("Share this link to your survey:", `${String(window.location).slice(0, String(window.location).lastIndexOf('/'))}/survey.php?s=${$(this).attr("data-shortcode")}`);
        });
    });

    $("a.deletebtn").each(function() {
        $(this).click(function(e) {
            if (!confirm("Are you sure you want to delete this survey? This action CANNOT be undone.")) {
                e.preventDefault();
                return false;
            }
        });
    });
});
