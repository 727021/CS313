var pageCount = 1;
var questionCount = [2];
var chkID = 0;
var radID = 0;
var radGrp = 0;

// From https://stackoverflow.com/a/4835406/2031203
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

    $("button#save-survey").click(function() {
        /**
         * For modal options:
         * https://stackoverflow.com/a/22208662/2031203
         */
        // Open a 'loading' modal

        // Gather survey data

        // Format data as JSON string

        // Send AJAX to action.php

        // Update modal with buttons to keep editing or go to dashboard

    });

    $("button#add-page").click(function() {
        // Create a new page
        $('#pages').append(`<div class="container mt-2 page" data-page="${pageCount + 1}">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title" data-page="${pageCount + 1}">Page ${pageCount + 1}</h3>
                    </div>
                    <div class="col text-right">
                        <button data-page="${pageCount + 1}" class="delete-page btn btn-danger" role="button" data-toggle="tooltip" data-placement="left" title="Delete Page"><i class="far fa-trash-alt"></i></button>
                    </div>
                </div>
            </div>
            <div class="questions" data-page="${pageCount + 1}">
                <div class="card-body border-top border-bottom" data-page="${pageCount + 1}" data-question="1">
                    <div class="row question-display">
                        <div class="col-10">
                            <div class="form-group">
                                <label data-qtype="0">What is your answer?</label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-2 text-right">
                            <button role="button" class="btn btn-info edit-question" data-toggle="tooltip" data-placement="top" title="Edit Question" data-page="${pageCount + 1}" data-question="1"><i class="far fa-edit"></i></button>
                            <button role="button" class="btn btn-danger delete-question" data-toggle="tooltip" data-placement="top" title="Delete Question" data-page="${pageCount + 1}" data-question="1" disabled><i class="far fa-trash-alt"></i></button>
                        </div>
                    </div>
                    <div class="question-editor" style="display: none;">
                        <div class="row form-group">
                            <div class="col-4">
                                <select class="custom-select question-type">
                                    <option value="0" selected>Textbox</option>
                                    <option value="0m">Textarea</option>
                                    <option value="1m">Checkboxes</option>
                                    <option value="1">Radio Buttons</option>
                                    <option value="2">Dropdown</option>
                                    <option value="2m">Select Menu</option>
                                    <!-- <option value="3">Slider</option> -->
                                </select>
                            </div>
                            <div class="col-6"></div>
                            <div class="col-2 text-right">
                                <button role="button" class="btn btn-success save-question" data-toggle="tooltip" data-placement="top" title="Save Question" data-page="${pageCount + 1}" data-question="1"><i class="far fa-save"></i></button>
                                <button role="button" class="btn btn-danger discard-question" data-toggle="tooltip" data-placement="top" title="Discard Changes" data-page="${pageCount + 1}" data-question="1"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" class="form-control question-content" value="What is your answer?" placeholder="Question">
                                </div>
                                <div class="question-details" style="display: none;"><!-- Not used for textbox/textarea questions -->
                                    <div class="options" data-page="${pageCount + 1}" data-question="1">
                                        <div class="row form-group option">
                                            <div class="col-5 pr-2">
                                                <input class="form-control" type="text" data-page="${pageCount + 1}" data-question="1" value="Choice 1">
                                            </div>
                                            <div class="col pl-0">
                                                <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="row form-group option">
                                            <div class="col-5 pr-2">
                                                <input class="form-control" type="text" data-page="${pageCount + 1}" data-question="1" value="Choice 2">
                                            </div>
                                            <div class="col pl-0">
                                                <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="row form-group option">
                                            <div class="col-5 pr-2">
                                                <input class="form-control" type="text" data-page="${pageCount + 1}" data-question="1" value="Choice 3">
                                            </div>
                                            <div class="col pl-0">
                                                <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                            </div>
                                        </div>
                                    </div><!-- .options -->
                                    <div class="row form-group">
                                        <div class="col"><button role="button" class="btn btn-info add-option"><i class="fas fa-plus"></i> Add Option</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .questions -->
            <div class="card-footer" data-page="${pageCount + 1}">
                <div class="row">
                    <div class="col text-center"><button data-page="${pageCount + 1}" role="button" class="add-question btn btn-info"><i class="fas fa-plus"></i> Add Question</button></div>
                </div>
            </div>
        </div>
    </div>`);
        // If necessary, enable first button.delete-page
        $('button.delete-page').first().removeAttr('disabled');
        // Add click listeners
        $page = $(`.page[data-page="${pageCount + 1}"]`).first();
        $page.find('button.delete-page').first().click(function() { deletePage(this); });
        $page.find('button.add-question').first().click(function() { addQuestion(this); });
        $page.find('button.delete-question').first().click(function() { deleteQuestion(this); });
        $page.find('button.edit-question').first().click(function(){ editQuestion(this); });
        $page.find('button.save-question').first().click(function() { saveQuestion(this); });
        $page.find('button.discard-question').first().click(function() { discardQuestion(this); });
        $page.find('button.add-option').first().click(function() { addOption(this); });
        $page.find('button.delete-option').each(function() { $(this).click(function() { deleteOption(this); }); });
        // Add change listeners
        $page.find('select.question-type').first().change(function() { questionType(this); });
        // Reload tooltips
        $('[data-toggle="tooltip"]').tooltip();
        // Increase page count
        questionCount[pageCount++] = 1;
    });

    // Edit survey title
    $("button#edit-title").unbind('click').click(function() {
        $("#edit-title-input").val($("#survey-title").text());
        $("#survey-title").hide();
        $("button#edit-title").hide().tooltip('hide');
        $("#edit-title-input").show();
        $("button#save-title").show();

    });

    // Save survey title
    $("button#save-title").unbind('click').click(function() {
        $("#survey-title").text(String($("#edit-title-input").val()).trim() == "" ? $("#survey-title").text() : $("#edit-title-input").val());
        $("#edit-title-input").hide();
        $("button#save-title").hide().tooltip('hide');
        $("#survey-title").show();
        $("button#edit-title").show();
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
    let index = Number($(btn).attr("data-page"));
    if (index != pageCount) {
        // This isn't the last page; there will be some renumbering to do
        let start = Number($(btn).attr("data-page"));
        $('[data-toggle="tooltip"]').tooltip('dispose');
        $(btn).parent().parent().parent().parent().parent().remove();
        $('[data-toggle="tooltip"]').tooltip();
        for (let i = start; i < pageCount; i++) {
            questionCount[i - 1] = questionCount[i];
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
    questionCount[pageCount - 1] = 0;
    pageCount--;
    if (pageCount == 1) {
        $("button.delete-page")[0].setAttribute("disabled", "");
    }
}

function addQuestion(btn) {
    if (btn == null) return;
    let page = Number($(btn).attr('data-page'));
    if (questionCount[page - 1] == null) questionCount[page - 1] = 0;
    let question = questionCount[page - 1] + 1;
    // Insert the question HTML
    $(btn).parent().parent().parent().prev().append(`<div class="card-body border-top border-bottom" data-page="${page}" data-question="${question}">
        <div class="row question-display" style="display: none;">
            <div class="col-10">
                <div class="form-group">
                    <label data-qtype="0">Question ${question}</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-2 text-right">
                <button role="button" class="btn btn-info edit-question" data-toggle="tooltip" data-placement="top" title="Edit Question" data-page="${page}" data-question="${question}"><i class="far fa-edit"></i></button>
                <button role="button" class="btn btn-danger delete-question" data-toggle="tooltip" data-placement="top" title="Delete Question" data-page="${page}" data-question="${question}"><i class="far fa-trash-alt"></i></button>
            </div>
        </div>
        <div class="question-editor">
            <div class="row form-group">
                <div class="col-4">
                    <select class="custom-select question-type">
                        <option value="0" selected>Textbox</option>
                        <option value="0m">Textarea</option>
                        <option value="1m">Checkboxes</option>
                        <option value="1">Radio Buttons</option>
                        <option value="2">Dropdown</option>
                        <option value="2m">Select Menu</option>
                        <!-- <option value="3">Slider</option> -->
                    </select>
                </div>
                <div class="col-6"></div>
                <div class="col-2 text-right">
                    <button role="button" class="btn btn-success save-question" data-toggle="tooltip" data-placement="top" title="Save Question" data-page="${page}" data-question="${question}"><i class="far fa-save"></i></button>
                    <button role="button" class="btn btn-danger discard-question" data-toggle="tooltip" data-placement="top" title="Discard Changes" data-page="${page}" data-question="${question}"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="row form-group">
                <div class="col">
                    <div class="form-group">
                        <input type="text" class="form-control question-content" value="Question ${question}" placeholder="Question">
                    </div>
                    <div class="question-details" style="display: none;"><!-- Not used for textbox/textarea questions -->
                        <div class="options" data-page="${page}" data-question="${question}">
                            <div class="row form-group option">
                                <div class="col-5 pr-2">
                                    <input class="form-control" type="text" data-page="${page}" data-question="${question}" value="Choice 1">
                                </div>
                                <div class="col pl-0">
                                    <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="row form-group option">
                                <div class="col-5 pr-2">
                                    <input class="form-control" type="text" data-page="${page}" data-question="${question}" value="Choice 2">
                                </div>
                                <div class="col pl-0">
                                    <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="row form-group option">
                                <div class="col-5 pr-2">
                                    <input class="form-control" type="text" data-page="${page}" data-question="${question}" value="Choice 3">
                                </div>
                                <div class="col pl-0">
                                    <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                        </div><!-- .options -->
                        <div class="row form-group">
                            <div class="col"><button role="button" class="btn btn-info add-option"><i class="fas fa-plus"></i> Add Option</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`);
    // Increase questionCount
    questionCount[page - 1] += 1;
    // Re-enable button.delete-question if necesary
    if (questionCount[page - 1] == 2) {
        $(`button.delete-question[data-page="${page}"]`).first().removeAttr('disabled');
    }
    // Add click listeners
    $card = $(`.card-body[data-page="${page}"][data-question="${question}"]`).first();
    $card.find('button.edit-question').first().click(function() { editQuestion(this); });
    $card.find('button.delete-question').first().click(function() { deleteQuestion(this); });
    $card.find('button.save-question').first().click(function() { saveQuestion(this); });
    $card.find('button.discard-question').first().click(function() { discardQuestion(this); });
    $card.find('button.delete-option').each(function() { $(this).click(function() { deleteOption(this); }); });
    $card.find('button.add-option').first().click(function() { addOption(this); });
    // Add select listener
    $card.find('select.question-type').first().change(function() { questionType(this); });
    // Reload tooltips
    $('[data-toggle="tooltip"]').tooltip();
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
    let type = Number($card.find('.question-type').first().val()[0]);
    if (type == 0) {
        $card.find('.question-details').first().hide();
    } else {
        $card.find('.question-details').first().show();
    }
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
                    <input type="checkbox" class="custom-control-input" id="chk${chkID}">
                    <label class="custom-control-label" for="chk${chkID++}">${escapeHtml(($editor.find(`.options [data-page="${page}"][data-question="${question}"]`).eq(i - 1).val() == null ? "Option" : $editor.find(`.options [data-page="${page}"][data-question="${question}"]`).eq(i - 1).val()))}</label>
                    </div>`;
                    i++;
        });
            break;
        case '1': // input:radio
        let j = 1;
        $editor.find('.options').first().children().each(function() {
            html += `<div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="rad${radID}" name="rad${radGrp++}">
                    <label class="custom-control-label" for="rad${radID++}">${escapeHtml($editor.find(`.options [data-page="${page}"][data-question="${question}"]`).eq(j - 1).val())}</label>
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
    $display.show().find('button.delete-question').first();
    // Update editor with previous data
    $editor.find('.question-content').first().val($display.children().first().children().first().children().first().text());
    $editor.find('.question-type').first().val($display.find('[data-qtype]').first().attr('data-qtype'));
    if (Number($editor.find('.question-type').first().val()[0]) == 1) { // check/radio
        html = "";
        $display.children().first().children().first().children('.custom-control').each(function() {
            html += `<div class="row form-group option"><div class="col-5 pr-2"><input class="form-control" type="text" data-page="${page}" data-question="${question}" value="${$(this).children().last().text()}"></div><div class="col pl-0"><button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button></div></div>`;
        });
        $editor.find('.options').first().html(html);
        $editor.find('.options').first().children().each(function() {
            $(this).find('button.delete-option').first().click(function() { deleteOption(this); }).tooltip();
        });
        $editor.find('.question-details').first().hide();
    } else if (Number($editor.find('.question-type').first().val()[0]) == 2) { // select
        html = "";
        $display.find('option').each(function() {
            html += `<div class="row form-group option"><div class="col-5 pr-2"><input class="form-control" type="text" data-page="${page}" data-question="${question}" value="${$(this).text()}"></div><div class="col pl-0"><button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button></div></div>`;
        });
        $editor.find('.options').first().html(html);
        $editor.find('.options').first().children().each(function() {
            $(this).find('button.delete-option').first().click(function() { deleteOption(this); }).tooltip();
        });
        $editor.find('.question-details').first().show();
    }
}

function questionType(sel) {
    let page = Number($(sel).parent().parent().parent().parent().attr('data-page'));
    let question = Number($(sel).parent().parent().parent().parent().attr('data-question'));
    // Check selected type
    let type = Number($(sel).val()[0]);
    // Create/remove options depending on type
    try { $('[data-toggle="tooltip"]').tooltip('dispose'); } catch (ex) {}
    if (type == 0) {
        $(sel).parent().parent().next().find('.question-details').first().hide();
    } else if (type < 3) {
        $(sel).parent().parent().next().find('.question-details').first().show();
    }
    $('[data-toggle="tooltip"]').tooltip();
}

function addOption(btn) {
    if (btn == null) return;
    $(btn).parent().parent().prev().append('<div class="row form-group option"><div class="col-5 pr-2"><input class="form-control" type="text" data-page="1" data-question="2" value="Option"></div><div class="col pl-0"><button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button></div></div>');
    $(btn).parent().parent().prev().find('button.delete-option').last().click(function() { deleteOption(this); });
    $(btn).parent().parent().prev().find('button.delete-option').last().tooltip();
    $(btn).parent().parent().prev().children().first().find('button.delete-option').first().removeAttr('disabled');
}

function deleteOption(btn) {
    if (btn == null) return;
    page = Number($(btn).parent().parent().parent().attr('data-page'));
    question = Number($(btn).parent().parent().parent().attr('data-question'));
    optionsCount = $(btn).parent().parent().parent().children().length;
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