var pageCount = 1;
var questionCount = [2];

// https://stackoverflow.com/a/4835406/2031203
function escapeHtml(text) {
    var map = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    };

    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
  }

$(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    $("button#save-title").hide();
    $("#edit-title-input").hide();
    $(".question-editor").each(function() {
        $(this).hide();
    });

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
        $('[data-toggle="tooltip"]').tooltip('dispose');
        $(btn).parent().parent().parent().parent().parent().remove();
        $('[data-toggle="tooltip"]').tooltip();
        for (let i = start; i < pageCount; i++) {
            $(`.page-title`)[i - 1].textContent = `Page ${i}`;
            $(`[data-page="${i + 1}"]`).each(function() {
                $(this).attr("data-page", i);
            });
        }
    } else {
        $('[data-toggle="tooltip"]').tooltip('dispose');
        $(btn).parent().parent().parent().parent().parent().remove();
        $('[data-toggle="tooltip"]').tooltip();
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
    let $card = $(btn).parent().parent().parent();
    $card.children().first().hide().next().show();
    $(btn).tooltip('hide');
    $card.find('.save-question').first().tooltip('show');
}

function saveQuestion(btn) {
    let $card = $(btn).parent().parent().parent().parent();
    let page = Number($card.attr('data-page'));
    let question = Number($card.attr('data-question'));
    let $display = $card.children().first();
    let $editor = $card.children().last();

    let html = `<label data-qtype="${$editor.find('.question-type').first().val()}">${escapeHtml($editor.find('.question-content').first().val())}</label>`;
    switch ($editor.find('.question-type').first().val()) {
        case '0': // input:text
        html += `<input type="text" class="form-control">`;
            break;
        case '0m':// textarea
        html += `<textarea class="form-control" rows="3"></textarea>`;
            break;
        case '1m': // input:checkbox
        let i = 1;
        $editor.find('.options').first().children().each(function() {
            html += `<div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="chk-p${page}-q${question}-o${i}">
                    <label class="custom-control-label" for="chk-p${page}-q${question}-o${i}">${escapeHtml($editor.find(`.options [data-page="${page}"][data-question="${question}"]`).eq(i - 1).val())}</label>
                    </div>`;
                    i++;
        });
            break;
        case '1': // input:radio
        let j = 1;
        $editor.find('.options').first().children().each(function() {
            html += `<div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="rad-p${page}-q${question}-o${j}" name="rad-p${page}-q${question}">
                    <label class="custom-control-label" for="rad-p${page}-q${question}-o${j}">${escapeHtml($editor.find(`.options [data-page="${page}"][data-question="${question}"]`).eq(j - 1).val())}</label>
                    </div>`;
                    j++;
        });
            break;
        case '2': // select
        let k = 1;
        html += '<select class="custom-select">';
        $editor.find('.options').first().children().each(function() {
            html += `<option>${escapeHtml($editor.find(`.options [data-page="${page}"][data-question="${question}"]`).eq(k - 1).val())}</option>`;
            k++;
        });
        html += '</select>';
            break;
        case '2m': // select[multiple]
        let l = 1;
        html += '<select class="custom-select" multiple>';
        $editor.find('.options').first().children().each(function() {
            html += `<option>${escapeHtml($editor.find(`.options [data-page="${page}"][data-question="${question}"]`).eq(l - 1).val())}</option>`;
            l++;
        });
        html += '</select>';
            break;
        case '3': // input:range
            break;
        default:
            break;
    }

    $display.find('.form-group').first().html(html);

    $card.children().last().hide().prev().show();
}

function discardQuestion(btn) {
    let $card = $(btn).parent().parent().parent().parent();
    let page = Number($card.attr('data-page'));
    let question = Number($card.attr('data-question'));
    let $display = $card.children().first();
    let $editor = $card.children().last();
    // Hide editor
    $editor.hide().find('button.discard-question').first().tooltip('hide');
    // Show display
    $display.show().find('button.delete-question').first().tooltip('show');
    // Update editor with previous data
    $editor.find('.question-content').first().val($display.children().first().children().first().children().first().text());
    $editor.find('.question-type').first().val($display.find('[data-qtype]').first().attr('data-qtype'));
    if (Number($editor.find('.question-type').first().val()[0]) == 1 || Number($editor.find('.question-type').first().val()[0]) == 2) { // check/radio/select
        html = "";

        $display.children().first().children().first().children('.custom-control').each(function() {
            html += `<div class="row form-group option"><div class="col-5"><input class="form-control" type="text" data-page="${page}" data-question="${question}" value="${$(this).children().last().text()}"></div><div class="col"><button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button></div></div>`;
        });

        $editor.find('.options').first().html(html);

        $editor.find('.options').first().children().each(function() {
            $(this).find('button.delete-option').first().click(function() { deleteOption(this); }).tooltip();
        });
    }
}

function questionType(sel) {
    // Check selected type

    // Create/remove (or show/hide?) options depending on type

}

function addOption(btn) {
    if (btn == null) return;
    $(btn).parent().parent().prev().append('<div class="row form-group option"><div class="col-5"><input class="form-control" type="text" data-page="1" data-question="2" value="Option"></div><div class="col"><button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button></div></div>');
    $(btn).parent().parent().prev().find('button.delete-option').last().click(function() { deleteOption(this); });
    $(btn).parent().parent().prev().find('button.delete-option').last().tooltip();
    $(btn).parent().parent().prev().children().first().find('button.delete-option').first().removeAttr('disabled');
}

function deleteOption(btn) {
    if (btn == null) return;
    page = Number($(btn).parent().parent().parent().attr('data-page'));
    question = Number($(btn).parent().parent().parent().attr('data-question'));
    optionsCount = $(btn).parent().parent().parent().children().length;
    console.log(`p${page} q${question} opt${optionsCount}`);
    if (optionsCount <= 1) return;
    $('[data-toggle="tooltip"]').tooltip('dispose');
    $(btn).parent().parent().remove();
    $('[data-toggle="tooltip"]').tooltip();
    if (optionsCount - 1 == 1) {
        $(`[data-page="${page}"][data-question="${question}"] button.delete-option`)[0].setAttribute("disabled", "");
    }
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