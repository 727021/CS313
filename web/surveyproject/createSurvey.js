var pageCount = 1;
var questionCount = [2];

$(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    $("button#save-title").hide();
    $("#edit-title-input").hide();

    // Edit survey title
    $("button#edit-title").unbind('click').click(function() {
        $("#edit-title-input").val($("#survey-title").text());
        $("#survey-title").hide();
        $("button#edit-title").hide().tooltip('hide');
        $("#edit-title-input").show();
        $("button#save-title").show().tooltip('show');
    });

    // Save survey title
    $("button#save-title").unbind('click').click(function() {
        $("#survey-title").text(String($("#edit-title-input").val()).trim() == "" ? $("#survey-title").text() : $("#edit-title-input").val());
        $("#edit-title-input").hide();
        $("#survey-title").show();
        $("button#save-title").hide().tooltip('hide');
        $("button#edit-title").show().tooltip('show');
    });

    // Delete a page
    $("button.delete-page").each(function() {
        $(this).click(function() {
            deletePage(this);
        });
    });

    // Add a question
    $("button.add-question").each(function() {
        $(this).unbind('click').click(function() {
            addQuestion(this);
        });
    });

    // Delete a question
    $("button.delete-question").each(function() {
        $(this).unbind('click').click(function() {
            deleteQuestion(this);
        });
    });

    // Edit a question
    $("button.edit-question").each(function() {
        $(this).unbind('click').click(function() {
            editQuestion(this);
        });
    });

    // Save a question
    $("button.save-question").each(function() {
        $(this).unbind('click').click(function() {
            saveQuestion(this);
        });
    });

    // Discard question changes
    $("button.discard-question").each(function() {
        $(this).unbind('click').click(function() {
            discardQuestion(this);
        });
    });

    // Change question type
    $("select.question-type").each(function() {
        $(this).unbind('change').change(function() {
            questionType(this);
        });
    });

    // Add an option
    $("button.add-option").each(function() {
        $(this).unbind('click').click(function() {
            addOption(this);
        });
    });

    // Delete an option
    $("button.delete-option").each(function() {
        $(this).unbind('click').click(function() {
            deleteOption(this);
        });
    });

    // Change slider type
    $("input.slider-type").each(function() {
        $(this).unbind('change').change(function() {
            sliderType(this);
        });
    });

    // Change slider min
    $("select.slider-min").each(function() {
        $(this).unbind('change').change(function() {
            sliderMin(this);
        });
    });

    // Change slider max
    $("select.slider-max").each(function() {
        $(this).unbind('change').change(function() {
            sliderMax(this);
        });
    });

});

function deletePage(btn) {
    if (btn == null) { return; }
    if (pageCount <= 1) {
        return; // Don't delete the last page
    }
    if (Number($(btn).attr("data-page")) != pageCount) {
        // This isn't the last page; there will be some renumbering to do
        let start = Number($(btn).attr("data-page"));
        $(btn).tooltip('dispose');
        $(btn).parent().parent().parent().parent().parent().remove();
        for (let i = start; i < pageCount; i++) {
            $(`.page-title`)[i - 1].textContent = `Page ${i}`;
            $(`[data-page="${i + 1}"]`).each(function() {
                $(this).attr("data-page", i);
            });
        }
    } else {
        $(btn).tooltip('dispose');
        $(btn).parent().parent().parent().parent().parent().remove();
    }
    pageCount--;
    if (pageCount == 1) {
        $("button.delete-page")[0].setAttribute("disabled", "");
    }
}

function addQuestion(btn) {

}

function deleteQuestion(btn) {
    if (btn == null) { return; }
    page = Number($(btn).attr('data-page'));
    question = Number($(btn).attr('data-question'));
    if (questionCount[page - 1] <= 1) { return; }
    if (question != questionCount[page - 1]) {
        try { $(`[data-toggle="tooltip"]`).tooltip('dispose'); } catch (ex) {}
        $(btn).parent().parent().parent().remove();
        $('[data-toggle="tooltip"]').tooltip();
        for (let i = question; i < questionCount[page - 1]; i++) {
            $(`[data-page="${page}"][data-question="${i + 1}"]`).each(function() {
                $(this).attr('data-question', i);
            });
        }
    } else {
        try { $('[data-toggle="tooltip"]').tooltip('dispose'); } catch (ex) {}
        $(btn).parent().parent().parent().remove();
        $('[data-toggle="tooltip"]').tooltip();
    }
    questionCount[page - 1]--;
    if (questionCount[page - 1] == 1) {
        $(`button.delete-question[data-page="${page}"]`)[0].setAttribute("disabled", "");
    }
}

function editQuestion(btn) {

}

function saveQuestion(btn) {

}

function discardQuestion(btn) {

}

function questionType(sel) {

}

function addOption(btn) {

}

function deleteOption(btn) {
    if (btn == null) return;
    page = Number($(btn).parent().parent().parent().attr('data-page'));
    question = Number($(btn).parent().parent().parent().attr('data-question'));
    optionsCount = $(btn).parent().parent().parent().children().length;
    console.log(`p${page} q${question} opt${optionsCount}`);
}

function sliderType(chk) {
    if (chk.checked) {

    } else {

    }
}

function sliderMin(sel) {

}

function sliderMax(sel) {

}