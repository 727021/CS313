$(function() {
    $("button[data-action='copy']").each(function() {
        $(this).click(function() {
            let target = $(this).attr("data-target");
            let copyText = $(target);

            copyText.select();
            copyText[0].setSelectionRange(0, 99999);

            document.execCommand("copy");

            $(`[data-copy='${target}']`).fadeIn().fadeOut();
        });
    });
});
