$(function() {
    $("button[data-action='copy']").each(function() {
        $(this).click(function() {
            let copyText = $($(this).attr("data-target"));

            copyText.select();
            copyText[0].setSelectionRange(0, 99999);

            document.execCommand("copy");

            copyText.val(copyText.val());
        });
    });
});
