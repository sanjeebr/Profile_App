$(document).ready(function() {
    var iserror = true;
    $( 'form' ).on( 'submit', function() {
        $('.empty').each(function() {
            var error = '#'.concat($(this).attr('id'), '_err');

            if (null === $(this).val() || '' === $(this).val()) {
                $(error).text('This field is required.');
                iserror = false;
            }
        });

        return iserror;
    });


    $('.only-char').on('keyup blur paste', function() {
        var letters = /^[a-zA-Z ]*$/;
        var error = '#'.concat($(this).attr('id'), '_err');

        if ( ! $(this).val().match(letters)) {
            $(error).text('Only letters and white space allowed.');
            iserror = false;
        } else if ($(this).val().length > 200 ) {
            $(error).text('Length must be less than 200 character.');
            iserror = false;
        } else {
            $(error).text('');
            iserror = true;
        }
    });

    $('.only-num').on('keyup blur paste', function() {
        var number = /^[0-9 ]*$/;
        var error = '#'.concat($(this).attr('id'), '_err');

        if ( ! $(this).val().match(number)) {
            $(error).text('Invalid data.');
            iserror = false;
        } else {
            $(error).text('');
            iserror = true;
        }
    });

    $('.street').on('keyup blur paste', function() {
        var street = /^[a-zA-Z\s\d-,]*$/;
        var error = '#'.concat($(this).attr('id'), '_err');

        if ( ! $(this).val().match(street)) {
            $(error).text('Invalid data.');
            iserror = false;
        } else if ($(this).val().length > 200 ) {
            $(error).text('Length must be less than 200 character.');
            iserror = false;
        } else {
            $(error).text('');
            iserror = true;
        }
    });

    $('#cpwd').on('keyup blur paste', function(){
        var str_length = $(this).val().length;

        if (str_length !== 0) {
            if ($(this).val() !== $('#pwd').val().substr(0, str_length)) {
                $('.cpwd_err').text('Password field does not match Confirm Password field');
                iserror = false;
            } else {
                $('.cpwd_err').text('');
                iserror = true;
            }
        }
    });

    $('.pin').on('blur', function(){
        var str_length = $(this).val().length;
        var error = '#'.concat($(this).attr('id'), '_err');

        if (str_length !== 0 && str_length !== 6) {
            $(error).text('Length must be 6.');
        } else {
            $(error).text('');;
            iserror = true;
        }
    });

    $('.phone').on('blur', function(){
        var str_length = $(this).val().length;
        var error = '#'.concat($(this).attr('id'), '_err');

        if (str_length !== 0 && str_length !== 10) {
            $(error).text('Length must be 10.');
        } else {
            $(error).text('');;
            iserror = true;
        }
    });

    $('.fax').on('blur', function(){
        var str_length = $(this).val().length;
        var error = '#'.concat($(this).attr('id'), '_err');
        if (str_length !== 0 && str_length !== 11) {
            $(error).text('Length must be 11.');
        } else {
            $(error).text('');;
            iserror = true;
        }
    });

    $('#pwd').on('blur', function() {
        var str_length = $(this).val().length;

        if ($(this).val() !== '') {
            if (str_length < 8) {
                $('.pwd_err').text('Password length must be greater than 8');
                iserror = false;
            } else if (str_length > 16) {
                $('.pwd_err').text('Password length must be less than 16');
                iserror = false;
            } else {
                $('.pwd_err').text('');
                iserror = true;
            }
        } else {
            $('.pwd_err').text('');
            iserror = true;
        }
    });

    $('#email').on('blur', function() {
        var email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        var error = '#'.concat($(this).attr('id'), '_err');

        if ( ! $(this).val().match(email)) {
            $(error).text('Invalid Email.');
            iserror = false;
        } else {
            $(error).text('');
            iserror = true;
        }
    });
});


