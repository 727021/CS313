$(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    $("button#save-title").hide();
    $("#edit-title-input").hide();

    $("button#edit-title").click(function() {
        $("#edit-title-input").val($("#survey-title").text().hide()).show();
        $("button#edit-title").hide();
        $("button#save-title").show();
    });

    $("button#save-title").click(function() {
        $("#survey-title").text(String($("#edit-title-input").val()).trim() == "" ? $("#survey-title").text() : $("#edit-title-input").val());
        $("#edit-title-input").hide();
        $("#survey-title").show();
        $("button#save-title").hide();
        $("button#edit-title").show();
    });
});

var pageCount = 0;

var pages = [];

function addPage() {

}

function removePage() {

}

function addQuestion(page) {

}

function removeQuestion(page, question) {

}
