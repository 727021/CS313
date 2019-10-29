$('#password').blur(function() {
    if ($(this).val().length < 7 || $(this).val().search(/[0-9]/) < 0) {
        $(this).addClass('is-invalid');
        $('#pass-length').show();
    } else {
        $(this).removeClass('is-invalid');
        $('#pass-length').hide();
    }
});

$('#confirm').blur(function() {
    if ($(this).val() != $('#password').val()) {
        $(this).addClass('is-invalid');
        $('#pass-match').show();
    } else {
        $(this).removeClass('is-invalid');
        $('#pass-match').hide();
    }
});

$('form').first().submit(function(e) {
    let valid = true;
    if ($('#password').val().length < 7 || $('#password').val().search(/[0-9]/) < 0) {
        $('#password').addClass('is-invalid');
        $('#pass-length').show();
    } else {
        $('#password').removeClass('is-invalid');
        $('#pass-length').hide();
        valid = false;
    }
    if ($('#confirm').val() != $('#password').val()) {
        $('#confirm').addClass('is-invalid');
        $('#pass-match').show();
    } else {
        $('#confirm').removeClass('is-invalid');
        $('#pass-match').hide();
        valid = false;
    }
    console.log(valid);
    if (!valid) e.preventDefault();
    return valid;
});